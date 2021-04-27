<?php

class About_us
{
    public function __construct()
    {
        $this->connect_database = new connect();
    }

    public function index()
    {
        $query = 'SELECT * FROM about_us';
        return $this->connect_database->run_query($query);
    }

    public function store($request)
    {
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");
        $name_image=$request['image'];
        $query = 'INSERT INTO about_us (title, description, image,created_at,updated_at)  VALUES ("'.$request['title'].'","'.$request['description'].'","'.$name_image .'","'.$created_at.'","'.$updated_at.'")';
        return $this->connect_database->run_query($query);
    }

    public function edit($id)
    {
        $query = 'SELECT * FROM about_us WHERE id='.$id ;
        return $this->connect_database->run_query($query);
    }

    public function update($request,$id)
    {
        $updated_at = date("Y-m-d H:i:s");
        $query = "UPDATE about_us SET title='".$request['title']."',description='".$request['description']."',image='".$request['image']."',updated_at='".$updated_at."' WHERE id=".$id;
        return $this->connect_database->run_query($query);
    }
}