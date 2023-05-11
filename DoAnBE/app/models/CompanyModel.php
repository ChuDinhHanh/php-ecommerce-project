<?php
class CompanyModel extends Model
{
    public function getAllCompany()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `company`');
        return parent::select($sql);
    }
}