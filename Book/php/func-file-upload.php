<?php

#file upload helper function..
function upload_file($files, $allowed_exs, $path){
    #get data and store them in var
    $file_name = $files['name'];
    $tmp_name  = $files['tmp_name'];
    $error     = $files['error'];

    #if there is no error occured during uploading.
    if($error === 0){
        #get file extention store it in var
        $file_ex = pathinfo($file_name, PATHINFO_EXTENSION);

        /**convert the file extension into 
         * lower case and store it in var */
        $file_ex_lc = strtolower($file_ex);

        /**check if the file extension
         * is exist in $allwed_exs array
         */
        if(in_array($file_ex_lc, $allowed_exs)){
            /**renaming the file 
             * with random strings
             */
            $new_file_name = uniqid("", true).'.'.$file_ex_lc;
            
            #assigning upload path
            $file_upload_path = '../uploads/'.$path.'/'.$new_file_name;
            /**moving uploaded file to
             * root directory upload/$path folder
             * 
             **/
            move_uploaded_file($tmp_name, $file_upload_path);
            /**creating success message associative array
             * with named keys status and data
             */
            $sm['status'] = 'success';
            $sm['data']   = $new_file_name;

            #Return the sm array
            return $sm;




        }else{
            /** creating error mesg */
            $em['status'] = 'error';
            $em['data']   = "You can't upload files of this type!";

            #Return the em array
            return $em;

        }

    }else{
        /** creating error mesg */
        $em['status'] = 'error';
        $em['data']   = 'Error occured while uploading!';

        #Return the em array
        return $em;

    }

}