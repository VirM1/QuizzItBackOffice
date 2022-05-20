<?php

namespace App\Manager;

use App\Entity\ReponseModuleThematique;
use App\Entity\Utilisateur;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializationContext;

class SerializerManager {

    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()->build();
    }

    public function serializeUser(Utilisateur $utilisateur)
    {
        $content = $this->serializer->serialize($utilisateur,"json",SerializationContext::create()->setGroups(array("serialize_user_detail")));
        return $content;
    }

    public function serializeReponseModuleThematique(ReponseModuleThematique $quizz)
    {
        $content = $this->serializer->serialize($quizz,"json",SerializationContext::create()->setGroups(array("serialize_quizz_detail")));
        return $content;
    }

}