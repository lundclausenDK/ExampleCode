<?php


class Text {

    private $profile_text = "Dette er en profil tekst.";

    public function __toString() {
        return $this->profile_text;
    }



}