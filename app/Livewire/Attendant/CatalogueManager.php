<?php
namespace App\Livewire\Attendant;
use App\Models\ProductCatalogue;
use Livewire\Component;
use Livewire\WithPagination;
class CatalogueManager extends Component {
    use WithPagination; public string $search=''; public string $product_name=''; public string $item=''; public ?string $editingId=null;
    public function updatedSearch(): void {$this->resetPage();}
    public function save(): void { $data=$this->validate(['product_name'=>'required|max:255','item'=>'nullable|max:255']); ProductCatalogue::updateOrCreate(['id'=>$this->editingId],$data); $this->reset(['product_name','item','editingId']); session()->flash('status','Catalogue item saved.'); }
    public function edit(ProductCatalogue $entry): void {$this->editingId=$entry->id;$this->product_name=$entry->product_name;$this->item=$entry->item??'';}
    public function delete(ProductCatalogue $entry): void {$entry->delete();}
    public function render(){return view('livewire.attendant.catalogue-manager',['entries'=>ProductCatalogue::when($this->search,fn($q)=>$q->where('product_name','like','%'.$this->search.'%'))->latest()->paginate(20)]);}
}
