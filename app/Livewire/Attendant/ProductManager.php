<?php
namespace App\Livewire\Attendant;
use App\Models\Category;
use App\Models\Product;
use App\Services\CloudinaryUploader;
use Illuminate\Support\Str;
use Throwable;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
class ProductManager extends Component {
    use WithFileUploads, WithPagination;
    public string $search=''; public ?string $editingId=null; public string $title=''; public string $brand='';
    public string $description=''; public string $price=''; public string $old_price=''; public string $stock_status='in_stock';
    public ?string $category_id=null; public bool $featured=false; public array $newImages=[];
    protected function rules(): array { return ['title'=>'required|max:255','brand'=>'nullable|max:100','description'=>'nullable','price'=>'required|numeric|min:0','old_price'=>'nullable|numeric|min:0','stock_status'=>'required','category_id'=>'nullable|exists:categories,id','featured'=>'boolean','newImages.*'=>'image|max:4096']; }
    public function updatedSearch(): void { $this->resetPage(); }
    public function edit(Product $product): void { $this->editingId=$product->id; foreach(['title','brand','description','price','old_price','stock_status','category_id','featured'] as $key) $this->$key=$product->$key ?? ($key==='featured'?false:''); }
    public function save(): void {
        $data=$this->validate(); unset($data['newImages']);
        $product=$this->editingId ? Product::findOrFail($this->editingId) : new Product;
        $data['slug']=$this->uniqueSlug($this->title,$product->id); $images=$product->images ?? [];
        try {
            foreach($this->newImages as $image) $images[]=app(CloudinaryUploader::class)->upload($image);
        } catch (Throwable $exception) {
            report($exception);
            $this->addError('newImages', 'The image upload failed. Check the Cloudinary settings and try again.');
            return;
        }
        $data['images']=$images; $product->fill($data)->save(); $this->resetForm(); session()->flash('status','Product saved.');
    }
    public function delete(Product $product): void { $product->delete(); session()->flash('status','Product deleted.'); }
    private function uniqueSlug(string $title, ?string $except=null): string { $base=Str::slug($title); $slug=$base; $i=2; while(Product::where('slug',$slug)->when($except,fn($q)=>$q->whereKeyNot($except))->exists()) $slug=$base.'-'.$i++; return $slug; }
    public function resetForm(): void { $this->reset(['editingId','title','brand','description','price','old_price','category_id','featured','newImages']); $this->stock_status='in_stock'; $this->resetValidation(); }
    public function render() { return view('livewire.attendant.product-manager',['products'=>Product::with('category')->when($this->search,fn($q)=>$q->where('title','like','%'.$this->search.'%'))->latest()->paginate(15),'categories'=>Category::orderBy('name')->get()]); }
}
