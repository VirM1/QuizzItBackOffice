<?php


namespace App\Manager;


use App\Entity\ModuleThematique;
use App\Entity\Question;
use App\Entity\Reponse;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Reader\Ods as odsReader;
use PhpOffice\PhpSpreadsheet\Reader\Csv as csvReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as xlsReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImportManager
{
    public const REQUIRED_FIELDS = array(
        "question",
        "r1",
        "r2",
        "r3",
        "r4",
        "b"
    );
    
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    
    public function generateBaseTemplate(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("template");
        /*foreach (self::REQUIRED_FIELDS as $key=>$field){
            $sheet->setCellValueExplicitByColumnAndRow($key+1,$key+1,$field,DataType::TYPE_STRING);
        }*/
        $sheet->fromArray(self::REQUIRED_FIELDS);

        $writer = new Xlsx($spreadsheet);
        $filename = "template.xlsx";

        $response= new StreamedResponse();
        $response->headers->set("Content-Type","application/vnd.ms-excel");
        $response->headers->set("Content-Disposition",sprintf("attachement;filename=%s",$filename));
        $response->headers->addCacheControlDirective("no-cache",true);
        $response->headers->addCacheControlDirective("must-revalidate",true);
        $response->setCallback(function () use ($writer){
            $writer->save("php://output");
        });
        return $response;


    }


    public function handleFileForQuestions(ModuleThematique $moduleThematique, UploadedFile $file)
    {//todo @Virgile à tester et améliorer
        try{
            switch ($file->getMimeType()){
                case "application/vnd.oasis.opendocument.spreadsheet":
                    $reader = new odsReader();
                    break;
                case "application/vnd.ms-excel":
                    $reader = new xlsReader();
                    break;
                default:
                    $reader = new csvReader();
                    $reader->setDelimiter(";");
                    break;
            }
            $reader->setInputEncoding('ISO-8859-1');
            $reader->setFallbackEncoding('ISO-8859-1');
            $spreadsheet = $reader->load($file->getRealPath());
            $data = $spreadsheet->getActiveSheet()->toArray();
            if($this->fieldsSecure($data[0])){
                unset($data[0]);
                foreach ($data as $row){
                    if(!empty($row[0])){
                        $question = new Question();
                        $question->setModuleThematique($moduleThematique);
                        $question->setTitreQuestion($row[0]);
                        $this->entityManager->persist($question);
                        $last = -1;
                        $reponses = array();
                        for ($i = 1;$i<5;$i++){
                            if(!empty($row[$i])){
                                $reponse = new Reponse();
                                $reponse->setTitreReponse($row[$i]);
                                $reponse->setQuestion($question);
                                array_push($reponses,$reponse);
                                $this->entityManager->persist($reponse);
                                $last = $i-1;
                            }
                        }
                        if($last !=-1  && count($reponses)>=1){
                            $number = intval(preg_replace("/[^0-9]/", "", $row[5]));
                            if($number != 0 && $number <= 4){
                                $question->setBonneReponse($reponses[$number-1]);
                            }else{//todo : prendre la dernière instance
                                $question->setBonneReponse($reponses[$last]);
                            }
                        }

                    }
                }
                $this->entityManager->flush();
            }

        }catch (\Exception $exception)
        {
            //todo : implement logger
            dd($exception);
        }
    }

    private function fieldsSecure(array $data)
    {
        foreach (self::REQUIRED_FIELDS as $key => $field){
            if($field != $data[$key]){
                return false;
            }
        }
        return true;
    }
}