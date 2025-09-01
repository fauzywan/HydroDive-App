<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class LandingEditor extends Component
{
       use WithFileUploads;

    public $data = [];
    public $formShow = 1;
    public $uploadTypeJumbotron = 1; // default
    public $uploadTypeJumbotron1 = 1; // default
    public $imageInputType1 = 1; // default
    public $imageInputType = 1; // default
    public $uploadedImage; // untuk file upload
    public $uploadedImage1; // untuk file upload
    public $imageUrl; // untuk input dari URL
public function updatedImageInputType()
{
        $this->uploadTypeJumbotron=$this->imageInputType;
        if($this->formShow==3 && $this->visiMisiImg!=""){
            $this->visiMisiImg="";
        }
    }
public function updatedImageInputType1()
{
        $this->uploadTypeJumbotron1=$this->imageInputType1;
        if($this->formShow==1 && $this->heroImg!=""){
            $this->heroImg="";
        }
    }
    public function mount()
    {
        $json = Storage::disk('public')->get('landing.json');
        $this->data = json_decode($json, true);
        $this->uploadTypeJumbotron=$this->imageInputType = $this->data['hero']['img_type']; // default
        $this->heroTitle=$this->data['hero']['judul'];
        $this->heroAppName=$this->data['hero']['appName'];
        $this->heroImg=$this->data['hero']['img'];
        $this->heroDesc=$this->data['hero']['deskripsi'];
        if($this->data['hero']['img_type']!="url"){
            $this->uploadTypeJumbotron1=2;
            $this->imageInputType1=2;
        }
        //
        $this->tentangTitle=$this->data['tentang_kami']['judul'];
        $this->tentangAppName=$this->data['tentang_kami']['appName'];
        $this->tentangDesc=$this->data['tentang_kami']['deskripsi'];
        //

        $this->lokasiTitle=$this->data['lokasi']['judul1'];
        $this->lokasiTitle2=$this->data['lokasi']['judul2'];
        $this->lokasiDesc=$this->data['lokasi']['deskripsi'];
        $this->lokasiDesc2=$this->data['lokasi']['deskripsi2'];
        $this->lokasiLihatMap=$this->data['lokasi']['lihat_map'];
        //
        $this->visiMisiTitle=$this->data['visi_misi']['judul'];
        $this->visiMisiVisi=$this->data['visi_misi']['visi'];
        $this->visiMisiImg=$this->data['visi_misi']['img'];
        if($this->data['visi_misi']['img_type']!="url"){
            $this->uploadTypeJumbotron=3;
            $this->imageInputType=3;
        }
        //
        $this->footerApp = $this->data['footer']['app'];
        $this->footerKontakJudul = $this->data['footer']['kontak']['judul'];
        $this->footerKontakItems = $this->data['footer']['kontak']['items'];
        $this->footerSosial = $this->data['footer']['media_sosial'];
        $this->footerCatatanForm = $this->data['footer']['catatan_form_kontak'];
    }
    public $heroTitle;
    public $heroAppName;
    public $heroDesc;
    public $heroImg;
    //
    public $lokasiTitle;
    public $lokasiTitle2;
    public $lokasiDesc;
    public $lokasiDesc2;
    public $lokasiLihatMap;
    //
    public $tentangTitle;
    public $tentangAppName;
    public $tentangDesc;
   //
    public $visiMisiTitle;
    public $visiMisiAppName;
    public $visiMisiVisi;
    public $visiMisiImg;
    //
    public $footerApp;
    public $footerKontakJudul;
    public $footerKontakItems = [];
    public $footerSosial = [];
    public $footerCatatanForm;
    public function save($no)
    {

        $this->data['hero']['img_type']="url";
        $this->data['visi_misi']['img_type']="url";
        if($no==1){
            $target = &$this->data['hero'];
            $baseName = 'hero-image';
            if($this->imageInputType1==2){
                $ext = $this->uploadedImage1->getClientOriginalExtension();
                $filename = $baseName . '.' . $ext;
                $folder = 'landing-images';
                $disk = 'public';
                $extensions = ['jpg', 'jpeg', 'png', 'webp'];
                foreach ($extensions as $oldExt) {
                    if (strtolower($ext) !== $oldExt) {
                        $oldPath = $folder . '/' . $baseName . '.' . $oldExt;
                        if (Storage::disk($disk)->exists($oldPath)) {
                            Storage::disk($disk)->delete($oldPath);
                        }
                    }
                }
                $path = $this->uploadedImage1->storeAs($folder, $filename, $disk);
                $this->heroImg=$target['img'] = '/storage/' . $path;
                $this->data['hero']['img_type']="storage";
            }
            $this->data['hero']['judul']=$this->heroTitle;
            $this->data['hero']['appName']=$this->heroAppName;
            $this->data['hero']['deskripsi']=$this->heroDesc;
            $this->data['hero']['img']=$this->heroImg;
        }
        elseif($no==2){
            $this->data['tentang_kami']['judul']=$this->tentangTitle;
            $this->data['tentang_kami']['appName']=$this->tentangAppName;
            $this->data['tentang_kami']['deskripsi']=$this->tentangDesc;
        }
        elseif($no==3){
         $target = &$this->data['visi_misi'];
            $baseName = 'visi-misi-image';
            if($this->imageInputType==3){
                $ext = $this->uploadedImage->getClientOriginalExtension();
                $filename = $baseName . '.' . $ext;
                $folder = 'landing-images';
                $disk = 'public';
                $extensions = ['jpg', 'jpeg', 'png', 'webp'];
                foreach ($extensions as $oldExt) {
                    if (strtolower($ext) !== $oldExt) {
                        $oldPath = $folder . '/' . $baseName . '.' . $oldExt;
                        if (Storage::disk($disk)->exists($oldPath)) {
                            Storage::disk($disk)->delete($oldPath);
                        }
                    }
                }
                $path = $this->uploadedImage->storeAs($folder, $filename, $disk);
                $this->visiMisiImg=$target['img'] = '/storage/' . $path;
                $this->data['visi_misi']['img_type']="storage";
            }
            $this->data['visi_misi']['judul']=$this->visiMisiTitle;
            $this->data['visi_misi']['visi']=$this->visiMisiVisi;
            $this->data['visi_misi']['img']=$this->visiMisiImg;

        }
        elseif($no==4){

            $this->data['lokasi']['judul1']= $this->lokasiTitle;
            $this->data['lokasi']['judul2']=$this->lokasiTitle2;
            $this->data['lokasi']['deskripsi']=$this->lokasiDesc;
            $this->data['lokasi']['deskripsi2']=$this->lokasiDesc2;

            $this->data['lokasi']['link_peta']=preg_match('/src="([^"]+)"/', $this->data['lokasi']['link_peta'], $matches);
            $this->data['lokasi']['link_peta']=$matches[1] ?? '';
            $this->data['lokasi']['lihat_map']=$this->lokasiLihatMap;
            }
            elseif ($no == 5) {
            $this->data['footer']['app'] = $this->footerApp;
            $this->data['footer']['kontak']['judul'] = $this->footerKontakJudul;
            $this->data['footer']['kontak']['items'] = $this->footerKontakItems;
            $this->data['footer']['media_sosial'] = $this->footerSosial;
            $this->data['footer']['catatan_form_kontak'] = $this->footerCatatanForm;
        }

        Storage::disk('public')->put('landing.json', json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $this->redirect('/app-settings',navigate:true);



    }
    public function saveLokasi()
    {
    }

    public function show($form)
    {
        $this->formShow = $form;
    }

    public function render()
    {
        return view('livewire.landing-editor');
    }
    public function addMisi()
{
    $this->data['visi_misi']['misi']['items'][] = '';
}
public function addKontak()
{
    $this->footerKontakItems[] = ['text' => '', 'deskripsi' => ''];
}

public function removeKontak($index)
{
    unset($this->footerKontakItems[$index]);
    $this->footerKontakItems = array_values($this->footerKontakItems);
}

public function addSosial()
{
    $this->footerSosial[] = ['platform' => '', 'icon' => '', 'url' => ''];
}

public function removeSosial($index)
{
    unset($this->footerSosial[$index]);
    $this->footerSosial = array_values($this->footerSosial);
}

public function removeMisi($index)
{
    unset($this->data['visi_misi']['misi']['items'][$index]);
    $this->data['visi_misi']['misi']['items'] = array_values($this->data['visi_misi']['misi']['items']);
}
}
