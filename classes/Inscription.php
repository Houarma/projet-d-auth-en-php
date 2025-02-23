<?php

    class Inscription{
            //methodes statics 
            public static function chiffer($password){
                return "aq1".sha1($password."123")."125";
            }
            public static function syntaxeEmail($email){
                if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
                else{
                    return true;
                }
            }
            public static function doublonEmail($email,$bdd){
                
                $emailInfo=$bdd->prepare("SELECT COUNT(*) AS emailNumber FROM users WHERE email=:email");
                $emailInfo->execute([
                    "email"=>$email
                ]);
                while ($userMail=$emailInfo -> fetch()) {
                    if ($userMail["emailNumber"]!=0) {
                        return true;
                    }
                    else{
                        return false;
                    }
                }
            }
        }