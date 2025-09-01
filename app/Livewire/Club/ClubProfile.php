<?php

namespace App\Livewire\Club;

use App\Models\Club;
use App\Models\ClubDocument;
use App\Models\ClubFacility;
use App\Models\ClubWaitingList;
use Flux\Flux;
use App\Models\ClubFacility as Facility;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodClub;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ClubProfile extends Component
{
    use WithFileUploads;
    public $first_name;
    public $fileName;
    public $photo;
    public $file;
    public $documents;
    public $documentId;
    public $club;
    public function updatedPhoto()
    {
        Flux::modal('edit-profile')->show();

    }
    public function updatedPaymentMethodSelect()
{
    $this->payment_method_input="";
}
    public function updateUserProfile(){
        if($this->photo){

            Storage::disk('public')->delete('club/' . $this->club->logo);
            $filename = md5($this->club->name) . '.' . $this->photo->getClientOriginalExtension();
            $path = $this->photo->storeAs('club', $filename, 'public');
            $this->club->update([
                'logo' => $filename,
            ]);
            session()->flash('message', 'Profile photo updated successfully.');
            if(auth()->user()->role_id==1){
                $clubID=$this->club->id;
                return $this->redirect("/club/$clubID/detail",navigate:true);

            }
            $this->redirect('/club/profile');
        }
    }
    public function download($id)
    {
        $doc=clubDocument::find($id);
    //  return   Storage::download("/club/document/".$doc->filename,"download.png");
    }
    public function destroy()
    {
        $doc=clubDocument::find($this->documentId);
        Storage::disk('public')->delete('club/document/' . $doc->filename);
        $doc->delete();
        session()->flash('message', 'Data berhasil Dihapus');
        if(auth()->user()->role_id==1){
            $clubID=$this->club->id;
            return $this->redirect("/club/$clubID/detail",navigate:true);

        }
        return $this->redirect('/club/profile',navigate:true);

    }
    public function delete($id)
    {
        $this->documentId=$id;
        $this->modalType=1;
        Flux::modal('modal-document')->show();

    }
    public $name;
    public $desc;
    public $statusFacility;
    public $hiddenin;
    public $srcPreview;
    public function detailFacility($id)
    {
           $this->hiddenin="";

        $facility=ClubFacility::find($id);
        $this->name=$facility->name;
        $this->desc=$facility->desc;
        $this->srcPreview="storage/club/facility/".$facility->photo;
        $this->hiddenin="hidden";
    }
    public $modalStatus=0;
    public function modalStatusChange($status){
        $this->modalStatus=$status;

    }
    public function imageFacility($id){
        $this->modalStatusChange(1);
        $photo=Facility::find($id)->photo;
        $this->srcPreview="storage/club/facility/$photo";
    }
    public function uploadDocument()
    {
        $rule=['file'=>'required','fileName'=>'required'];
        $this->validate($rule);
        $count=ClubDocument::where('club_id',$this->club->id)->get()->count();
        $filename =$this->club->id."_".$this->fileName . "_$count." . $this->file->getClientOriginalExtension();
        $this->file->storeAs('/club/document', $filename, 'public');
        ClubDocument::create(['name'=>$this->fileName,'club_id'=>$this->club->id,'filename'=>$filename]);
        if(auth()->user()->role_id==1){
            $clubID=$this->club->id;
            return $this->redirect("/club/$clubID/detail",navigate:true);

        }
        return redirect()->route('club.profile')->with('message', 'Data berhasil disimpan');
    }
    public $message;
    public function removeMembership(){

        $this->club->update(['status'=>0]);
        ClubWaitingList::create([
            'club_id'=>$this->club->id,
            "status"=>2,
            "message"=>$this->message,
            "Approver"=>auth()->user()->name]);
        session()->flash('message', 'Membership Status successfully removed.');
        Flux::modal('remove-membership')->close();
    }
    public function removeMembershipModal(){
        Flux::modal('remove-membership')->show();
    }
    public function addMembership(){
        $this->club->update(['status'=>1]);
        if(ClubWaitingList::where('club_id',$this->club->id)->where('status',1)->get()->count()>0){
            ClubWaitingList::where('club_id',$this->club->id)->update(['status'=>0]);
        }
        session()->flash('message', 'Membership request sent successfully.');
    }
public function requestMembership(){
    if(ClubWaitingList::where('club_id',$this->club->id)->get()->count()>0){

    }else{

    }
    ClubWaitingList::create(['club_id'=>$this->club->id,"status"=>1,"message"=>"","Approver"=>""]);
    if(auth()->user()->role_id==1){
        $clubID=$this->club->id;
        return $this->redirect("/club/$clubID/detail",navigate:true);

    }
    return $this->redirect('/club/profile',navigate:true);
}
public $waitingList;
    public function mount($id=null)
    {
        if($id){
            $this->club=Club::find($id);
        }else{

            $this->club=auth()->user()->club;
        }
        $this->documents=ClubDocument::where('club_id',$this->club->id)->get();
        $this->waitingList=(ClubWaitingList::where('club_id',$this->club->id)->orderBy('created_at','desc')->get());

    }
    public function render()
    {


        return view('livewire.club.club-profile',['waitingList'=>$this->waitingList]);
    }
    public $modalType=1;
    public function edit($id){
        return $this->redirect("/club/$id/edit",navigate:true);

    }
    public function addDocument()
    {
        $this->modalType=2;
        Flux::modal('modal-document')->show();
    }
    public $formShow=1;
    public $facilities;
    public function show($no){
        $this->formShow=$no;
        if($no==5 && $this->facilities==null){
            $this->facilities=ClubFacility::where('club_id',$this->club->id)->get();
        }
    }
    public $paymentMethods;
    public $payment_method_input;
    public $payment_method_address;
    public $payment_method_select=1;
    public $photoQr;

    public function addPaymentMethod(){
        $this->modalType=3;
        $this->paymentMethods=PaymentMethod::all();
        if(!$this->paymentMethods->count()){
            $this->payment_method_select=0;

        }
        Flux::modal('modal-document')->show();

    }
    public $pm;
    public function deleteMethod($id){
           $this->pm=PaymentMethodClub::find($id);
           $this->first_name=$this->pm->id;
        $this->modalType=4;
        Flux::modal('modal-document')->show();

    }
    public function destroyMethod(){
        if($this->pm->photo!=""){
            Storage::disk('public')->delete('club/payment/method/' . $this->pm->photo);

        }
        $this->pm->delete();
          session()->flash('message', 'delete successfully.');
          Flux::modal('modal-document')->close();
            $this->paymentMethods=PaymentMethod::all();

    }
    public function newMethod()
    {

        if($this->payment_method_input!=""){
            $payment_method_select= PaymentMethod::create(['name'=>$this->payment_method_input]);
            $this->payment_method_select=$payment_method_select->id;
        }
        $filename="";
        if($this->photoQr){
            $filename = md5($this->club->name) . "$this->payment_method_select" .'.' . $this->photoQr->getClientOriginalExtension();
            $path = $this->photoQr->storeAs('club/payment/method', $filename, 'public');
        }
        PaymentMethodClub::create([
            'payment_method_id'=>$this->payment_method_select,
        'club_id'=>$this->club->id,
        'payment_address'=>$this->payment_method_address,
        'photo'=>$filename]);
          session()->flash('message', 'insert successfully.');
          Flux::modal('modal-document')->close();
           $this->paymentMethods=[];
           $this->payment_method_input="";
           $this->payment_method_address="";
           $this->payment_method_select=1;
           $this->photoQr;
            $this->paymentMethods=PaymentMethod::all();

    }
}
