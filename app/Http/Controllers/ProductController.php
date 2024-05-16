<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required",
            "price" => "required|numeric",
            "description" =>"required|nullable"
        ],[
            "title.required" => "Ürün adını boş bırakmayınız",
            "price.required" => "Fiyat bilgisini boş bırakmayınız",
            "price.numeric" => "Fiyat kısmına sadece sayı giriniz",
            "description.required" => "Açıklama kısmını boş bırakmayınız",

        ]
        );
        $data["title"] = $request->title;
        $data["price"] = $request->price;
        $data["description"] = $request->description;
        $newProduct = Product::create($data);
        if(!$newProduct){
            return redirect(route("product.update"))->with("error","oluşturulamadı");
        }
        return redirect(route("product.home"))->with("success","Başarıyla oluşturuldu");
    }


    public function create()
    {
        if(Auth::check())
        {
            return view("product.create");
        }
        return redirect(route("login"))->with("error","Login olmadan anasayfaya erişemezsiniz");

    }


    public function home()
    {
        if(Auth::check())
        {
            $products = Product::all();
            return view("product.home",['products' => $products]);
        }
        return redirect(route("login"))->with("error","Login olmadan anasayfaya erişemezsiniz");
    }


    public function update(Product $product, Request $request)
    {
        $data = $request->validate([
            "title"=> "required",
            "price"=> "required|numeric",
            "description"=>"required|nullable"
        ],[
            "title.required" => "Ürün adını boş bırakmayınız",
            "price.required" => "Fiyat bilgisini boş bırakmayınız",
            "price.numeric" => "Fiyata metin bilgisi girmeyiniz",
            "description.required" => "Açıklama kısmını boş bırakmayınız",

        ]
        );
        $product->update($data);
        return redirect(route("product.home"))->with("success","Başarıyla güncellendi");

    }


    public function edit(Product $product)
    {
        if(Auth::check())
        {
            return view("product.update",['product' => $product]);
        }
        return redirect(route("login"))->with("error","Login olmadan anasayfaya erişemezsiniz");

    }


    public function destroy(Product $product)
    {
        if(Auth::check())
        {
            $product->delete();
            return redirect(route("product.home"))->with("success","Başarıyla silindi");
        }
        return redirect(route("login"))->with("error","Login olmadan anasayfaya erişemezsiniz");

    }


    public function detail(Product $product)
    {
        if(Auth::check())
        {
            $data = Product::find($product);
            return view("product.detail",compact("product"));
        }
        return redirect(route("login"))->with("error","Login olmadan anasayfaya erişemezsiniz");

    }
}
