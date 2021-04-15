<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use App\Models\User;
use App\Models\Fabric;
use App\Models\UserSession;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductFabric;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CardDetails;
use App\Models\CustomerAddress;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\ProductTranslation;
use App\Models\UserSizes;
use App\Models\KandoraStyle;
use App\Models\CollarSleeveStyle;
use App\Models\PromotionCode;
use App\Models\FabricColor;
use App\Models\MakeProducts;
use App\Models\OrderedProduct;
use App\Models\RequestTrailer;
use App\Models\KandoraPrice;
use App\Models\OrderUserSizes;
use App\Models\ShippingCharg;


class BaseController extends Controller
{
    public $deleted = 'deleted';
    public $created = 'created';
    public $updated = 'updated';

    public function __construct(){
    	$this->Log = new Log;
    	$this->Fabric = new Fabric;
    	$this->Size = new Size;
    	$this->Color = new Color;
    	$this->Product = new Product;
    	$this->ProductImage = new ProductImage;
    	$this->ProductSize = new ProductSize;
    	$this->ProductColor = new ProductColor;
    	$this->ProductFabric = new ProductFabric;
    	$this->Order = new Order;
    	$this->OrderItems = new OrderItems;
    	$this->Cart = new Cart;
    	$this->CartItem = new CartItem;
    	$this->CardDetails = new CardDetails;
    	$this->CustomerAddress = new CustomerAddress;
    	$this->User = new User;
        $this->UserSession = new UserSession;
        $this->OrderStatus = new OrderStatus;
        $this->PaymentStatus = new PaymentStatus;
        $this->ProductTranslation = new ProductTranslation;
        $this->KandoraStyle = new KandoraStyle;
        $this->CollarSleeveStyle = new CollarSleeveStyle;
    	$this->UserSizes = new UserSizes;
        $this->PromotionCode = new PromotionCode;
        $this->FabricColor = new FabricColor;
        $this->MakeProducts = new MakeProducts;
        $this->OrderedProduct = new OrderedProduct;
        $this->RequestTrailer = new RequestTrailer;
        $this->KandoraPrice = new KandoraPrice;
        $this->OrderUserSizes = new OrderUserSizes;
        $this->ShippingCharg = new ShippingCharg;
        
    }

    public function debugLog($e = NULL){
        if(\Config::get('admin.project_mode') == 'live'){
            Log::debug('#APIs'.$e);
            return response()->json("Something wen't wrong..!");
        }
        else
        {   
            return response()->json($e);
        }
    }
}
