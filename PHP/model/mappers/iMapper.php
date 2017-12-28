<?php

interface iMapper {
    function getConnection();
    function add($Object);
    function load($id);
}