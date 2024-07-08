<?php
namespace App\Components;
class Recusive{
    private $data;
    private $option = '';
    
    public function __construct($data)
    {
        $this->data=$data;
    }
    public function RecusiveType($id=0,$text='')
    {

        foreach($this->data as $value)
        {
            
            if($value['parent_id']==$id){
                $this->option.='<tr>
                                <td>'.$text.$value['name'].'</td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="'. route('type.edit',['id'=>$value->id]) .'"><i class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                        <a href="'. route('type.delete',['id'=>$value->id]) .'"><i class="bi bi-trash-fill fs-5"></i></a>
                                    </div>
                                </td>
                            </tr>';
                $this->RecusiveType($value['id'],$text.'--');
            }
        }
        return $this->option;
    }
    public function RecusiveCategory($id=0,$text='')
    {

        foreach($this->data as $value)
        {
            
            if($value['parent_id']==$id){
                $this->option.='<tr>
                                <td>'.$text.$value['name'].'</td>
                                <td>'.(($value['image']!=null)?'<img width="100px" height="100px" src="'.asset($value['image']).'" >':'').'</td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="'. route('category.edit',['id'=>$value->id]) .'"><i class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                        <a href="'. route('category.delete',['id'=>$value->id]) .'"><i class="bi bi-trash-fill fs-5"></i></a>
                                    </div>
                                </td>
                            </tr>';
                $this->RecusiveCategory($value['id'],$text.'--');
            }
        }
        return $this->option;
    }
    public function RecusiveMenu($id=0,$text='')
    {

        foreach($this->data as $value)
        {
            
            if($value['parent_id']==$id){
                $this->option.='<tr>
                                <td>'.$text.$value['name'].'</td>
                                <td>'.$value['number'].'</td>
                                <td>'.$value['url'].'</td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="'. route('category.edit',['id'=>$value->id]) .'"><i class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                        <a href="'. route('category.delete',['id'=>$value->id]) .'"><i class="bi bi-trash-fill fs-5"></i></a>
                                    </div>
                                </td>
                            </tr>';
                $this->RecusiveMenu($value['id'],$text.'--');
            }
        }
        return $this->option;
    }
    public function categoryRecusive($parent_id,$id=0,$text='',)
    {

        foreach($this->data as $value)
        {
            if($value['parent_id']==$id){
                if(!empty($parent_id) && $parent_id==$value['id']){
                    $this->option.='<option selected value="'.$value['id'].'">'.$text.$value['name'].'</option>';
                }else{
                    $this->option.='<option value="'.$value['id'].'">'.$text.$value['name'].'</option>';
                }
                $this->categoryRecusive($parent_id,$value['id'],$text.'--');
            }
        }
        return $this->option;
    }
    public function typeRecusive($parent_id,$id=0,$text='',)
    {

        foreach($this->data as $value)
        {
            if($value['parent_id']==$id){
                if(!empty($parent_id) && $parent_id==$value['id']){
                    $this->option.='<option selected value="'.$value['id'].'">'.$text.$value['name'].'</option>';
                }else{  
                    $this->option.='<option value="'.$value['id'].'">'.$text.$value['name'].'</option>';
                }
                $this->typeRecusive($parent_id,$value['id'],$text.'--');
            }
        }
        return $this->option;
    }
    public function menuRecusive($parent_id,$id=0,$text='')
    {
        foreach($this->data as $value)
        {
            if($value['parent_id']==$id){
                if(!empty($parent_id) && $parent_id==$value['id']){
                    $this->option.='<option selected value="'.$value['id'].'">'.$text.$value['name'].'</option>';
                }else{
                    $this->option.='<option value="'.$value['id'].'">'.$text.$value['name'].'</option>';
                }
                $this->menuRecusive($parent_id,$value['id'],$text.'--');
            }
        }
        return $this->option;
    }
}