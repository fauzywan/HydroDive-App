<?php

namespace App\Livewire\Category;

use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
class SwimmingCategoryModal extends Component
{
    use WithFileUploads;

    public $selectedCategory;
    public $distanceIs;
    #[Rule("numeric")]
    public $distance;
    #[Rule("nullable|numeric")]
    public $length;
    #[Rule("string|max:255")]
    public $style;
    #[Rule("string|max:5")]
    public $gender="man";
    #[Rule("string")]
    public $pool_type;
    #[Rule("boolean")]
    public $relay=0;
    #[Rule("string|nullable")]
    public $description;
    public $category;

    public $modalText="Add";
    public $modalSubText="Create New Athlete Data";
    public $athleteId;
    public $athlete;
    public $formType="save";
    public $isEditMode = false;

    public $formStage=0;
    public $nextButton="Next";
    public $prevButton="Back";
    public $photoPrev='';
    public function prevForm(){
        if($this->formStage>0){
        $this->formStage-=1;
        $this->nextButton="Next";
        }
    }
    public $selectedType=0;
    public function changeType()
    {
        $this->selectedType=!$this->selectedType;
        if($this->selectedType==0){
            $this->length=0;
        }
    }
    public function nextForm(){
        if($this->formStage<=1){
            $this->formStage+=1;
            $this->nextButton="Next";
        }
        if($this->formStage==1){
            $this->prevButton="Back";
            $this->nextButton="Save";
            if($this->selectedType==1){
                $this->distanceIs=$this->length."x".$this->distance."M";
            }else{
                $this->distanceIs=$this->distance."M";

            }
        }

    }
    public function save()
    {
        $swimType="individual";
        if($this->relay==1){
            $swimType="Relay";
        }
       $description="$this->distanceIs $this->style $this->gender $this->pool_type $swimType";
        Category::create([
            'no'=>0,
            'distance'=>"'".$this->distanceIs."'",
            'style'=>$this->style,
            'gender'=>strtoupper($this->gender),
            'pool_type'=>$this->pool_type,
            'description'=>"$description",
            'relay'=>$this->relay,
    ]);
    session()->flash('message', 'Data berhasil Ditambahkan');
        return $this->redirect('swimming-category',navigate:true);
    }
    #[On('refreshInput')]
    public function refreshInput(){
        $this->changeFormType('save');
        $this->distance="";
        $this->length="";
        $this->style="";
        $this->relay=0;
    }
    #[On('editModal')]
    public function edit($id){
    $this->changeFormType('update');
        $this->selectedCategory=Category::findorfail($id);
        $this->selectedType=$this->selectedCategory->relay;
        $this->relay=$this->selectedCategory->relay;
        $this->distance=trim(implode("",explode("M",$this->selectedCategory->distance)));
        $this->length=$this->selectedCategory->length;
        if($this->relay==1){
            $this->length=trim(explode('x',$this->distance)[0]);
            $this->distance=trim(explode('x',$this->distance)[1]);
        }
        $this->style=$this->selectedCategory->style;
        $this->pool_type=$this->selectedCategory->pool_type;
        Flux::modal('athlete-modal')->show();
    }
    public function update(){
        $this->validate();
        $swimType="";
        if($this->relay==1){
            $swimType="Relay";
        }
       $description="$this->distanceIs $this->style $this->gender $this->pool_type $swimType";

     $this->selectedCategory->update([
            'distance'=>$this->distanceIs,
            'style'=>$this->style,
            'gender'=>strtoupper($this->gender),
            'pool_type'=>$this->pool_type,
            'description'=>"$description",
            'relay'=>$this->relay]);
            session()->flash('message', 'Data berhasil Diubah');
        return $this->redirect('swimming-category',navigate:true);

    }
    #[On('deleteModal')]
    public function delete($id){
        $this->category=$id;
        Flux::modal('delete-profile')->show();
    }
    public function destroy(){
        DB::table('categories')->where('id',$this->category)->delete();
        session()->flash('message', 'Data berhasil Dihapus');
        return $this->redirect('swimming-category',navigate:true);
}

    public function changeFormType($type){
        $this->formType=$type;
    }

    public function render()
    {
        return view('livewire.category.swimming-category-modal');
    }
}
