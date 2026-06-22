<?php
namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCatalogue;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::query()->where('role','!=','attendant')->delete();
        User::updateOrCreate(['email'=>env('ATTENDANT_EMAIL','attendant@shopictgadgets.co.ke')],['name'=>env('ATTENDANT_NAME','Attendant'),'password'=>Hash::make(env('ATTENDANT_PASSWORD','change-this-password')),'role'=>'attendant','is_active'=>true]);
        $export=database_path('data/neon-export.json');
        if(is_file($export) && $this->importNeon($export)) return;
        $path=database_path('data/products.csv'); if(!is_file($path)) return;
        $handle=fopen($path,'r'); $headers=fgetcsv($handle);
        while(($values=fgetcsv($handle))!==false){ if(count($headers)!==count($values)) continue; $row=array_combine($headers,$values); $title=trim($row['Name']??''); if(!$title) continue;
            $categoryName=trim(explode('>',explode(',', $row['Categories']??'Uncategorized')[0])[0])?:'Uncategorized';
            $category=Category::firstOrCreate(['slug'=>Str::slug($categoryName)],['name'=>$categoryName]);
            $images=array_values(array_filter(array_map('trim',explode(',', $row['Images']??''))));
            $slug=Str::slug($title).'-'.($row['ID']??Str::random(6));
            $product=Product::updateOrCreate(['slug'=>$slug],['category_id'=>$category->id,'title'=>$title,'brand'=>trim($row['Brands']??''),'description'=>strip_tags($row['Description']?:($row['Short description']??'')),'price'=>(float)($row['Sale price']?:($row['Regular price']?:0)),'old_price'=>($row['Sale price']??'')!==''?(float)($row['Regular price']??0):null,'stock_status'=>($row['In stock?']??'1')==='1'?'in_stock':'out_of_stock','images'=>$images,'featured'=>($row['Is featured?']??'0')==='1','priority'=>(int)($row['Position']??0)]);
            ProductCatalogue::firstOrCreate(['product_name'=>$title],['product_id'=>$product->id,'item'=>$categoryName]);
        } fclose($handle);
    }

    private function importNeon(string $path): bool {
        $data=json_decode(file_get_contents($path),true); if(empty($data['products'])) return false;
        foreach($data['categories']??[] as $row) Category::updateOrCreate(['id'=>$row['id']],['slug'=>$row['slug'],'name'=>$row['name']??$row['title']??Str::headline($row['slug']),'image'=>$row['image']??null,'priority'=>$row['sort_order']??0]);
        foreach($data['products'] as $row){
            $categoryId=null; if(!empty($row['category_id'])) $categoryId=Category::where('id',$row['category_id'])->value('id');
            Product::updateOrCreate(['id'=>$row['id']],['slug'=>$row['slug'],'category_id'=>$categoryId,'title'=>$row['title'],'brand'=>$row['brand']??null,'description'=>$row['description']??null,'price'=>$row['price']??0,'old_price'=>$row['old_price']??null,'stock_status'=>$row['stock_status']??'in_stock','images'=>$row['images']??[],'specs'=>$row['specs']??null,'featured'=>$row['featured']??false,'priority'=>$row['category_priority']??0]);
        }
        foreach($data['product_catalogue']??[] as $row) ProductCatalogue::updateOrCreate(['id'=>$row['id']],['product_id'=>$row['product_id']??null,'product_name'=>$row['product_name']??$row['title'],'item'=>$row['item']??null,'specs'=>$row['specs']??null]);
        foreach($data['settings']??[] as $row) DB::table('settings')->updateOrInsert(['key'=>$row['key']],['value'=>json_encode($row['value']),'created_at'=>now(),'updated_at'=>$row['updated_at']??now()]);
        foreach($data['orders']??[] as $row) DB::table('orders')->updateOrInsert(['id'=>$row['id']],['reference'=>'NEON-'.$row['id'],'customer_name'=>$row['customer_name'],'phone'=>$row['customer_phone']??'','email'=>null,'items'=>is_string($row['items'])?$row['items']:json_encode($row['items']??[]),'total'=>$row['total']??0,'status'=>$row['status']??'pending','created_at'=>$row['created_at']??now(),'updated_at'=>$row['updated_at']??now()]);
        foreach($data['inquiries']??[] as $row) DB::table('inquiries')->updateOrInsert(['id'=>$row['id']],['product_id'=>null,'name'=>$row['customer_name']??'Customer','phone'=>$row['customer_phone']??'','email'=>null,'message'=>$row['message']??json_encode($row['items']??[]),'status'=>$row['status']??'pending','created_at'=>$row['created_at']??now(),'updated_at'=>$row['updated_at']??now()]);
        return true;
    }
}
