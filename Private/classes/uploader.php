<?php
    class Uploader{


        public $filename;
        public $tempname;    
        public $folder;
        public $filenameOld;

        public function __construct($filenameOld,$tempname,$folder)
        {
            $this->flienameOld=$filenameOld;
            $this->fileName = uniqid('',true).".".$filenameOld;
            $this->tempname=$tempname;
            $this->folder=$folder;
        }

        public function uploadImage(){
            if (move_uploaded_file($this->tempname, $this->folder))  {
                $msg = "Image uploaded successfully";
            }else{
                $msg = "Failed to upload image";
            }
        }
    }



?>