<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ebook extends Model
{
    //

    public $table = 'ebook';
    public $primaryKey = 'Id_ebook';
    public $timestamps = false;
    public $fillable = ['Id_ebook', 'Id_sub_category','Id_template','Title','Content','Image','Pdf_file','Call_to_action','Status'];
    public $incrementing = true;

    public function add_ebook($Id_template, $id_sub_category,$Title,$Content, $Image, $pdf, $Call_to_action)
    {
        ebook::create(
        [
            'Id_ebook' => null,
            'Id_template' => strtoupper($Id_template),
            'Id_sub_category' => $id_sub_category,
            'Title' => strtoupper($Title),
            'Content' => strtoupper($Content),
            'Image' => $Image,
            'Pdf_file' => $pdf,
            'Call_to_action' => $Call_to_action,
            'Status'=>1
        ]
        );
        return "sukses";

    }


    public function edit_ebook($id, $Id_template, $id_sub_category,$Title,$Content, $Image, $pdf, $Call_to_action)
    {
      
        ebook::where('Id_ebook','=',$id)->update(array(
            'Id_template' => strtoupper($Id_template),
            'Id_sub_category' => $id_sub_category,
            'Title' => strtoupper($Title),
            'Content' => strtoupper($Content),
            'Image' => $Image,
            'Pdf_file' => $pdf,
            'Call_to_action' => $Call_to_action,
            'Status'=>1
        ));
        return "sukses";
      

    }

    public function delete_ebook($id)
    {
        $current_ebook = ebook::find($id);
        ebook::where('Id_ebook','=',$id)->update(array(
            'Status' => 0
        ));

        unlink(public_path() ."/Uploads/Ebook/". $current_ebook->Image);
        unlink(public_path() ."/Uploads/Ebook/". $current_ebook->Pdf_file);

    }
}
