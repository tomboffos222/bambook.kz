<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Models\Tree;
use App\Models\User;
use App\OrderProduct;
use App\Orders;
use App\Tree2;
use App\UserBalanceOperation;
use Illuminate\Http\Request;
use App\BlackListed;
use App\Authors;
use App\Product;
use App\Categories;

use App\Withdrawal;
use App\Message;
class UserController extends Controller

{
    public function addProduct(Request $request){

        $rules = [
            'product_id' => 'required|max:255'
        ];
        $messages = [

            "product_id.required" => "Введите название книги или имя автора",

        ];
        $validator = $this->validator($request->all(),$rules, $messages);

        if ($validator->fails()){
            return back()->withErrors($validator->errors());

        }else{
            $user = session()->get('user');
            if ($user ==null){
                return back()->withErrors('Войдите в систему чтобы пользоваться корзиной');
            }else {
                $request['product_id'] = intval($request['product_id']);
                $request['user_id'] = intval($request['user_id']);
                $basket = Basket::where([
                    ['user_id', '=', $user['id']],
                    ['products', '=', $request['product_id']],
                ])->first();

                if (!$basket) {

                    $basket = new Basket;

                    $basket['quantity'] = 1;
                    $basket['user_id'] = $user['id'];
                    $basket['products'] = $request['product_id'];
                    $product = Product::find($request['product_id']);

                    $basket['total'] = $basket['quantity'] * $product['price'];
                    $basket->save();

                } else {
                    $basket['quantity'] += 1;
                    $product = Product::find($request['product_id']);
                    $basket['total'] = $basket['quantity'] * $product['price'];


                    $basket->save();


                }
                $baskets = Basket::where('user_id', $request['user_id'])->get();
                $mainCount = 0;
                foreach ($baskets as $basket) {
                    $mainCount = $mainCount + $basket['quantity'];
                }
                session()->put('count', $mainCount);
                return back()->with('message', 'Добавлено в корзину');
            }


        }









    }
    public function SearchForm(Request $request){
        $rules = [
            'name' => 'required|max:255'
        ];
        $messages = [
            "name.required" => "Введите название книги или имя автора",
            "name.max"=>"Максимальное количество символов 255"
        ];
        $validator = $this->validator($request->all(),$rules, $messages);

        if ($validator->fails()){
            return back()->withErrors($validator->errors());



        }else{
            $data['products'] = Product::where('title', 'LIKE', '%'.$request['name'].'%')->orWhere('author','LIKE','%'.$request['name'].'%')->paginate(12);
            $data['authors'] = Authors::get();
            $data['categories'] = Categories::get();
            return view('shop',$data);
        }
    }
    public function DeleteProduct(Request $request){
        $rules = [
            'user_id' => 'required|max:255',
            'product_id' => 'required|max:255'
        ];
        $messages = [
            "user_id.required" => "Войдите чтобы добавить в корзину",
            "product_id.required" => "Введите название книги или имя автора",
            "user_id.max"=>"Максимальное количество символов 255"
        ];
        $validator = $this->validator($request->all(),$rules, $messages);

        if ($validator->fails()){
            return back()->withErrors($validator->errors());

        }else{
            $request['product_id'] = intval($request['product_id']);
            $request['user_id'] = intval($request['user_id']);
            $basket = Basket::where([
                ['user_id', '=', $request['user_id']],
                ['products', '=', $request['product_id']],
            ])->first();
            $basket->delete();





        }

        return back()->with('message','Удалено с корзины');

    }
    public function WithdrawShow(){
        $user = session()->get('user');
        $data['user'] = User::find($user['id']);
        $data['withdraws'] = Withdrawal::join('users', 'withdrawals.user_id', '=', 'users.id')->paginate(12);


        $user = User::find($user['id']);



        return view('withdraw',$data);

    }
    public function WithdrawCreate(Request $request){
        $rules = [
            'amount' => 'required|max:1000000'
        ];
        $messages = [
            "amount.required" => "Введите сумму для вывода средств",
            "amount.max"  => "Максимальное количество средств для вывода 999999"
        ];
        $validator = $this->validator($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());

        }else{
            if ($request['withdraw_type'] == 'bill'){
                $user = session()->get('user');
                $user = User::find($user['id']);

                $summary = $user['bill'] - $request['amount'];
                $amount = $request['amount'];
                if ($summary < 0) {

                    return back()->withErrors('Недостаточно средств');

                    # code...
                }else{



                    $data['withdraw'] = $amount;
                    $data['summary'] = $summary;
                    $data['user'] = $user;


                    return view('withdrawnext',$data);

                }
            }else{
                $user = session()->get('user');
                $user = User::find($user['id']);

                $maximalWithdraw = $user['deposit_bill']*0.5;
                if ($request['amount']>$maximalWithdraw){
                    return back()->withErrors('Невозможно вывести больше 50% от общей суммы депозита');
                }else{
                    $summary = $user['deposit_bill'] - $request['amount'] - $user['deposit_bill']*0.25;
                    $data['amount'] = $request['amount'];
                    $data['summary'] = $summary;
                    $data['user']  = $user;
                    return view('withdrawnext',$data);
                }


            }
        }
    }
    public function OrderView($id){
        $user = session()->get('user');
        $data['user'] = User::find($user['id']);
        $data['order'] = Orders::find($id)->first();
        $data['products'] = Product::join('order_products','products.id','=','order_products.productId')->select('products.*','quantity','orderId')->where('orderId',$id)->paginate(12);

        return view('orderview',$data);
    }
    public function Bots(){
        $user = session()->get('user');
        $data['user'] = User::find($user['id']);
        $data['bots'] = User::where('bot_owner_id',$user['id'])->paginate(12);
        return view('bots',$data);
    }
    public function Bonuses(){
        $user = session()->get('user');
        $data['user'] = User::find($user['id']);
        $data['bonuses'] = UserBalanceOperation::where('user_id',$user['id'])->paginate(12);
        return view('bonuses',$data);
    }
    public function Orders(){
        $user = session()->get('user');
        $data['user']  =  User::find($user['id']);
        $data['orders'] = Orders::where('user_id',$user['id'])->paginate(12);
        return view('orders',$data);
    }
    public function Refers(){
        $user = session()->get('user');
        $data['user'] = User::find($user['id']);
        $data['refers'] = User::where('referBy',$user['id'])->paginate(12);
        return view('refers',$data);
    }
    public function DeleteAll(){

        $user = session()->get('user');
        $basket = Basket::where('user_id',$user['id'])->delete();
        return redirect()->route('Home')->with('message','Все удалено с корзины');
    }
    public function OrderForm(Request $request){
        $user = session()->get('user');

        if($user == null) {
            return back()->withErrors('Войдите чтобы воспользоваться корзиной');
        }else {
            $rules = [

                'quantity' => 'required|max:255',
                'total' => 'required|max:255'
            ];
            $messages = [


            ];
            $validator = $this->validator($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            } else {



                $data['quantity'] = $request['quantity'];
                $data['total'] = $request['total'] * 0.95;


            }
            return view('order', $data);
        }
    }
    public function OrderCreate(Request $request){
        $rules = [
            'index'=> 'required|max:255',
            'phone_number' => 'required|max:255',
            'address' => 'required|max:255',
            'region' => 'required|max:255',
            'city' => 'required|max:255'
        ];
        $messages = [
           "index.required" => "Введите индекс",
            "phone_number.required" => "Введите номер телефона",
            "region.required" =>"Введите регион",
            "city.required" => "Введите свой город"
        ];
        $validator = $this->validator($request->all(),$rules,$messages);
        if ($validator->fails()){
            return back()->withErrors($validator->errors());
        }else {
            $user = session()->get('user');
            if ($user == null) {
                return back()->withErrors('message', 'Войдите чтобы воспользоваться корзиной');
            } else {
                $order = new Orders;
                $order['user_id'] = $user['id'];
                $order['quantity'] = $request['quantity'];
                $order['total'] = $request['total'];
                $order['index'] = $request['index'];
                $order['phone_number'] = $request['phone_number'];
                $order['address'] = $request['address'];
                $order['region'] = $request['region'];
                $order['city'] = $request['city'];
                $order['type_of_order'] = $request['type_of_order'];
                $order['status'] = 'waiting';
                $order->save();
                $user = session()->get('user');
                $user = User::find($user['id']);
                $products = Product::join('baskets', 'products.id', '=', 'baskets.products')->select('products.*', 'quantity', 'total', 'user_id')->where('user_id', $user['id'])->get();
                foreach ($products as $product) {
                    $orderProducts = new OrderProduct;
                    $orderProducts['orderId'] = $order['id'];
                    $orderProducts['productId'] = $product['id'];
                    $orderProducts['quantity'] = $product['quantity'];
                    $orderProducts->save();
                }
                if($request['purchase'] == 'deposit_balance'){
                    $sum = $user['deposit_bill'] - $order['total'];
                    if($sum <0){
                        $order['status'] = 'fail';
                        $order->save();
                        return back()->withErrors('У вас недостаточно средств');
                    }else{
                        $order['status'] = 'success';
                        $order->save();
                        $user['deposit_bill'] = $sum;
                        $user->save();
                        return back()->with('message','Успешно оплачено');
                    }
                }elseif($request['purchase'] == 'balance'){
                    $sum = $user['bill'] - $order['total'];
                    if($sum <0){
                        $order['status'] = 'fail';
                        $order->save();
                        return back()->withErrors('У вас недостаточно средств');
                    }else{
                        $order['status'] = 'success';
                        $order->save();
                        $user['bill'] = $sum;
                        $user->save();
                        return back()->with('message','Успешно оплачено');
                    }
                }else{

                }

            }
        }

    }
    public function CartPage(){

        $user = session()->get('user');
        $data['products'] = Product::join('baskets','products.id','=','baskets.products')->select('products.*','quantity','total','user_id')->where('user_id',$user['id'])->paginate(12);
        $products= Product::join('baskets','products.id','=','baskets.products')->where('user_id',$user['id'])->paginate(12);
        $data['quantity']  = 0;

        foreach($products as $product){
            $data['quantity']  = $data['quantity'] + $product['quantity'];
        }

        $data['total']=0;
        foreach($products as $product){
            $data['total'] = $data['total']+$product['total'];
        }





        return view('cart', $data);


    }



    public function Up(){
        $user= session()->get('user');

        $data['user'] = User::find($user['id']);
        return view('up',$data);
    }

    public function AccountUp(){
        $user= session()->get('user');

        $user = User::find($user['id']);

        //$user['bill'] = $user['bill'] - 20000;

        if ($user['bill'] < 0 ) {

            return back()->withErrors('Недостаточно средств');
            # code...
        }else{
            $user['status'] = 'partner';

            $user->save();
            $this->AddUserToMatrix($user->id);

            return back()->with('message','Оплачено, ваш статус: партнер');


        }


    }
    function AddReferToMatrix($user_id,$refer_id,$type){
        if ( Tree::whereUserId($user_id)->exists()){
            return back()->withErrors('Уже зарегистрирован');
        }

        if($type == 1) {
            $parentUser = Tree::where('user_id', $refer_id)->first();
            $childUsers = Tree::where('parent_id', $refer_id)->get();
            $lastChild = Tree::where('parent_id', $refer_id)->orderBy('id', 'desc')->first();
            $neighbours = Tree::where('parent_id', $lastChild->parent_id)->get();
            if (count($neighbours) < 2) {
                $new = new Tree();
                $new->user_id = $user_id;
                $new->parent_id = $lastChild->parent_id;
                $new->parents = $lastChild->parents;
                $new->row = $parentUser->row + 1;
                $new->save();
                $this->Giver($new);
            } else {
                $childs = Tree::where('parents', 'LIKE', '%' . $refer_id . '%')->get();
                foreach ($childs as $child) {
                    $childKids = Tree::where('parent_id', $child['id'])->count();
                    if ($childKids < 2) {
                        $childKid = Tree::where('parent_id', $child['id'])->first();
                        if ($childKid) {
                            $new = new Tree();
                            $new->user_id = $user_id;
                            $new->parent_id = $childKid->parent_id;
                            $new->parents = $childKid->parents;
                            $new->row = $childKid->row;
                            $new->save();
                            $this->Giver($new);
                        } else {
                            $new = new Tree();
                            $new->user_id = $user_id;
                            $new->parent_id = $child->id;
                            $new->parents = $child->parents . ',' . $child->id;
                            $new->row = $child->row + 1;
                            $new->save();
                            $this->Giver($new);

                        }
                        break;
                    }
                }


            }
        }elseif($type==2){
            $parentUser = Tree2::where('user_id',$refer_id)->first();
            $childUsers  =Tree2::where('parent_id',$refer_id)->get();
            $lastChild = Tree2::where('parent_id',$refer_id)->orderBy('id','desc')->first();
            $neighbours = Tree2::where('parent_id',$lastChild->parent_id)->get();
            if (count($neighbours)<2){
                $new = new Tree2();
                $new->user_id = $user_id;
                $new->parent_id = $lastChild->parent_id;
                $new->parents = $lastChild->parents;
                $new->row = $parentUser->row + 1;
                $new->save();
                $this->SecondGiver($new);
            }else {
                $childs = Tree2::where('parents', 'LIKE', '%' . $refer_id . '%')->get();
                foreach ($childs as $child) {
                    $childKids = Tree2::where('parent_id', $child['id'])->count();
                    if ($childKids < 2) {
                        $childKid = Tree::where('parent_id', $child['id'])->first();
                        if ($childKid) {
                            $new = new Tree2();
                            $new->user_id = $user_id;
                            $new->parent_id = $childKid->parent_id;
                            $new->parents = $childKid->parents;
                            $new->row = $childKid->row;
                            $new->save();
                            $this->SecondGiver($new);
                        } else {
                            $new = new Tree2();
                            $new->user_id = $user_id;
                            $new->parent_id = $child->id;
                            $new->parents = $child->parents . ',' . $child->id;
                            $new->row = $child->row + 1;
                            $new->save();
                            $this->SecondGiver($new);

                        }
                        break;
                    }
                }
            }
        }




    }
    function AddUserToMatrix($user_id){
        if (Tree::whereUserId($user_id)->exists()){
            return back()->withErrors('Уже зарегистрированы');
        }

        $lastUser = Tree::orderBy('id','desc')->first();


        $neighbours =  Tree::where('parent_id',$lastUser->parent_id)->get();
        if (count($neighbours) < 2){
            $parentUser  = Tree::where('id',$lastUser->parent_id)->first();

            $new = new Tree();
            $new->user_id = $user_id;
            $new->parent_id = $lastUser->parent_id;
            $new->parents = $lastUser->parents;
            $new->row = $parentUser->row + 1;
            $new->save();
            $this->Giver($new);

        } else{
            $parentUser = Tree::where('id',$lastUser->parent_id)->first();
            $nextUser = Tree::where('row',$parentUser->row)->where('id','>',$parentUser->id)->first();
            if ($nextUser){
                $new = new Tree();
                $new->user_id = $user_id;
                $new->parent_id = $nextUser->id;
                $new->parents = $nextUser->parents.','.$nextUser->id;
                $new->row = $nextUser->row + 1;
                $new->save();
                $this->Giver($new);
            }else{
                $nextUser = Tree::where('row',$lastUser->row)->first();
                $new = new Tree();
                $new->user_id = $user_id;
                $new->parent_id = $nextUser->id;
                $new->parent_id = $nextUser->id;
                $new->parents = $nextUser->parents.','.$nextUser->id;
                $new->row = $nextUser->row + 1;

                $new->save();
                $this->Giver($new);
            }


        }


    }
    protected  function Giver($new){
        $parents = explode(',',$new->parents);

        $parents = array_reverse($parents);
        if (!empty($parents[0])){
            $user = Tree::where('parents','LIKE','%'.$parents[0].'%')->where('row',$new->row)->get();
            if(!empty($user[1])) {
                $user2 = $user[1];

                if ($new['user_id'] == $user2['user_id']) {
                    $parentAccount = User::where('id', $parents[0])->first();

                    $parentAccount['bill'] += 5000;
                    $parentAccount->save();
                    $ubo = new UserBalanceOperation();
                    $ubo['user_id'] = $parentAccount['id'];
                    $ubo['desc'] = 'Получение бонуса за 1 ряд';
                    $ubo['sum'] = 5000;
                    $ubo->save();

                }
            }
        }
        if (!empty($parents[1])){
            $user = Tree::where('parents','LIKE','%'.$parents[1].'%')->where('row',$new->row)->get();
            if(!empty($user[5])) {
                $user4 = $user[3];

                if ($new['user_id'] == $user4['user_id']) {
                    $parentAccount = User::where('id', $parents[1])->first();
                    $parentAccount['bill'] += 10000;
                    $parentAccount->save();
                    $ubo = new UserBalanceOperation();
                    $ubo['user_id'] = $parentAccount['id'];
                    $ubo['desc'] = 'Получение бонуса за 2 ряд';
                    $ubo['sum'] = 10000;
                    $ubo->save();

                }
            }
        }
        if (!empty($parents[2])){
            $user = Tree::where('parents','LIKE','%'.$parents[2].'%')->where('row',$new->row)->get();
            if(!empty($user[13])) {
                $user8 = $user[7];

                if ($new['user_id'] == $user8['user_id']) {
                    $parentAccount = User::where('id', $parents[2])->first();
                    $parentAccount['bill'] += 20000;
                    $parentAccount->save();
                    $ubo = new UserBalanceOperation();
                    $ubo['user_id'] = $parentAccount['id'];
                    $ubo['desc'] = 'Получение бонуса за 3 ряд';
                    $ubo['sum'] = 20000;
                    $ubo->save();

                }
            }
        }
        if (!empty($parents[3])){
            $user = Tree::where('parents','LIKE','%'.$parents[3].'%')->where('row',$new->row)->get();
            if(!empty($user[15])) {
                $user16 = $user[15];

                if ($new['user_id'] == $user16['user_id']) {
                    $parentAccount = User::where('id', $parents[3])->first();
                    $parentAccount['bill'] += 40000;
                    $parentAccount->save();
                    $ubo = new UserBalanceOperation();
                    $ubo['user_id'] = $parentAccount['id'];
                    $ubo['desc'] = 'Получение бонуса за 4 ряд';
                    $ubo['sum'] = 40000;
                    $ubo->save();
                }
            }
        }
        if (!empty($parents[4])){
            $user = Tree::where('parents','LIKE','%'.$parents[4].'%')->where('row',$new->row)->get();
            if(!empty($user[15])) {

                $user32 = $user[15];

                if ($new['user_id'] == $user32['user_id']) {
                    $parentAccount = User::where('id', $parents[4])->first();
                    $parentAccount['bill'] += 50000;

                    $parentAccount->save();
                    $ubo = new UserBalanceOperation();
                    $ubo['user_id'] = $parentAccount['id'];
                    $ubo['desc'] = 'Получение бонуса за 5 ряд';
                    $ubo['sum'] = 100000;
                    $ubo->save();

                    $uboNew = new UserBalanceOperation();
                    $uboNew['user_id'] = $parentAccount['id'];
                    $uboNew['desc'] = 'Оплата за второй этап';
                    $uboNew['sum'] = 50000;
                    $uboNew->save();
                }
            }
        }

    }
    function AddUserToSecondMatrix($user_id){
        if (Tree2::whereUserId($user_id)->exists()){
            return back()->withErrors('Уже зарегистрированы');
        }

        $lastUser = Tree2::orderBy('id','desc')->first();


        $neighbours =  Tree2::where('parent_id',$lastUser->parent_id)->get();
        if (count($neighbours) < 2){
            $parentUser  = Tree2::where('id',$lastUser->parent_id)->first();

            $new = new Tree2();
            $new->user_id = $user_id;
            $new->parent_id = $lastUser->parent_id;
            $new->parents = $lastUser->parents;
            $new->row = $parentUser->row + 1;
            $new->save();
            $this->SecondGiver($new);

        } else{
            $parentUser = Tree2::where('id',$lastUser->parent_id)->first();
            $nextUser = Tree2::where('row',$parentUser->row)->where('id','>',$parentUser->id)->first();
            if ($nextUser){
                $new = new Tree2();
                $new->user_id = $user_id;
                $new->parent_id = $nextUser->id;
                $new->parents = $nextUser->parents.','.$nextUser->id;
                $new->row = $nextUser->row + 1;
                $new->save();
                $this->SecondGiver($new);
            }else{
                $nextUser = Tree2::where('row',$lastUser->row)->first();
                $new = new Tree2();
                $new->user_id = $user_id;
                $new->parent_id = $nextUser->id;
                $new->parent_id = $nextUser->id;
                $new->parents = $nextUser->parents.','.$nextUser->id;
                $new->row = $nextUser->row + 1;

                $new->save();
                $this->SecondGiver($new);
            }


        }


    }
    protected  function SecondGiver($new){
        $parents = explode(',',$new->parents);

        $parents = array_reverse($parents);
        if (!empty($parents[0])){
            $user = Tree2::where('parents','LIKE','%'.$parents[0].'%')->where('row',$new->row)->get();
            if(!empty($user[1])) {
                $user2 = $user[1];

                if ($new['user_id'] == $user2['user_id']) {
                    if ($new['bot_owner_id'] ==  null) {
                        $parentAccount = User::where('id', $parents[0])->first();
                        $parentAccount['bill'] += 10000;
                        $parentAccount->save();
                        $ubo = new UserBalanceOperation();
                        $ubo['user_id'] = $parentAccount['id'];
                        $ubo['desc'] = 'Получение бонуса за второй этап 1 ряд';
                        $ubo['sum'] = 10000;
                        $ubo->save();
                    }


                }
            }
        }
        if (!empty($parents[1])){
            $user = Tree2::where('parents','LIKE','%'.$parents[1].'%')->where('row',$new->row)->get();
            if(!empty($user[3])) {
                $user4 = $user[3];

                if ($new['user_id'] == $user4['user_id']) {
                    if($new['bot_owner_id'] == null) {
                        $parentAccount = User::where('id', $parents[1])->first();
                        $parentAccount['bill'] += 20000;
                        $parentAccount->save();
                        $ubo = new UserBalanceOperation();
                        $ubo['user_id'] = $parentAccount['id'];
                        $ubo['desc'] = 'Получение бонуса за второй этап 2  ряд';
                        $ubo['sum'] = 20000;
                        $ubo->save();
                    }


                }
            }
        }
        if (!empty($parents[2])){
            $user = Tree2::where('parents','LIKE','%'.$parents[2].'%')->where('row',$new->row)->get();
            if(!empty($user[7])) {
                $user8 = $user[7];

                if ($new['user_id'] == $user8['user_id']) {
                    if($new['bot_owner_id'] == null) {
                        $parentAccount = User::where('id', $parents[2])->first();
                        $parentAccount['bill'] += 40000;
                        $parentAccount->save();
                        $ubo = new UserBalanceOperation();
                        $ubo['user_id'] = $parentAccount['id'];
                        $ubo['desc'] = 'Получение бонуса за второй этап 3 ряд';
                        $ubo['sum'] = 40000;

                        $ubo->save();
                    }


                }
            }
        }
        if (!empty($parents[3])){
            $user = Tree2::where('parents','LIKE','%'.$parents[3].'%')->where('row',$new->row)->get();
            if(!empty($user[15])) {
                $user16 = $user[15];

                if ($new['user_id'] == $user16['user_id']) {
                    if($new['bot_owner_id'] == null) {
                        $parentAccount = User::where('id', $parents[3])->first();
                        $parentAccount['bill'] += 80000;
                        $parentAccount->save();
                        $ubo = new UserBalanceOperation();
                        $ubo['user_id'] = $parentAccount['id'];
                        $ubo['desc'] = 'Получение бонуса за второй этап 4 ряд';
                        $ubo['sum'] = 80000;
                        $ubo->save();
                    }elseif($new['bot_owner_id'] != null){
                        $parentAccount = User::where('id',$new['bot_owner_id'])->first();
                        $parentAccount['deposit_bill'] +=100000;
                        $parentAccount->save();
                        $ubo = new UserBalanceOperation();
                        $ubo['user_id'] = $parentAccount['id'];
                        $ubo['desc'] = 'Получение бонуса за второй этап 4 ряд бота'.$new['name'];
                        $ubo['sum'] = 100000;
                        $ubo->save();
                    }


                }
            }
        }
        if (!empty($parents[4])){
            $user = Tree2::where('parents','LIKE','%'.$parents[4].'%')->where('row',$new->row)->get();
            if(!empty($user[31])) {
                $user32 = $user[31];

                if ($new['user_id'] == $user32['user_id']) {
                    $parentAccount = User::where('id', $parents[4])->first();
                    $parentAccount['bill'] += 200000;

                    $parentAccount->save();
                    $ubo = new UserBalanceOperation();
                    $ubo['user_id'] = $parentAccount['id'];
                    $ubo['desc'] = 'Получение бонуса за второй этап 5 ряд';
                    $ubo['sum'] = 200000;
                    $ubo->save();



                }
            }
        }

    }

    public function Home(){

        $data['products'] = Product::orderBy('id','desc')->paginate(12);
        $data['authors'] = Authors::paginate(12);
        $data['categories'] = Categories::paginate(20);
        $data['sliders'] = Product::orderBy('id','desc')->paginate(3);




        return view('home',$data);
    }
    public function Shop(){
        $data['products'] = Product::orderBy('id')->paginate(7);
        $data['authors'] = Authors::get();
        $data['categories'] = Categories::get();



        return view('shop',$data);
    }
    public function Search(Request $request){

        $rules = [
            'category' =>'required|max:255',
            'author' =>'required|max:255'

        ];

        $messages = [
            "category.required" => "Выберите категорию",
            "author.required" => "Выберите автора"
        ];
        $validator = $this->validator($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());

        }else{
            if ($request['category'] == 'All') {
                $data['products'] = Product::paginate(12);
                $data['authors'] = Authors::get();
                $data['categories'] = Categories::get();
                if($request['author'] != 'All'){

                $data['products'] =Product::where('author','LIKE','%'.$request['author'].'%')->paginate(12);
                $data['authors'] = Authors::get();
                $data['categories'] = Categories::get();

                }

                # code...
            }elseif ($request['category'] != 'All') {

                $data['products'] =Product::where('chars','LIKE','%'.$request['category'].'%')->paginate(12);
                $data['authors'] = Authors::get();
                $data['categories'] = Categories::get();
                if($request['author'] != 'All'){

                $data['products'] =Product::where('author','LIKE','%'.$request['author'].'%');
                $data['products']  = $data['products']->where('chars','LIKE','%'.$request['category'].'%')->paginate(12);

                $data['authors'] = Authors::get();
                $data['categories'] = Categories::get();

                }

                # code...
            }
            return view('shop',$data);


        }


    }

    public function Product($productId){
        $products = Product::where('id','!=',$productId)->get();
        $product = Product::find($productId);


        return view('product',['products'=>$products,'product'=>$product]);
    }
    public function RegisterPage(){
        return view('register');
    }
    public function Category($categoryId){
        $data['categories'] = Categories::get();
        $data['authors'] = Authors::get();
        $category = Categories::find($categoryId);
        $data['products'] = Product::where('chars' , 'LIKE', '%'.$category['chars'].'%')->paginate(12);



        return view ('shop',$data);

    }
    public function Authors(){

        $data['authors'] = Authors::paginate(10);
        return view('authors',$data);
    }
    public function Author($authorId){
        $author = Authors::find($authorId);

        $products = Product::where('author','LIKE','%'.$author['Name'].'%')->paginate(10);


        return view('author',['author'=>$author , 'products' => $products]);
    }
    public function Register(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',

            'password' =>'required|max:255',
            'phone' => 'required',
            'email' => 'required|email',
            'zhsn' => 'required|max:14'
        ];

        $messages = [

            "name.required" => "Введите ваше имя",
            "password.required" =>"Введите пароль",
            "login.unique" => "Логин занять,введите другой логин",
            "phone.required" => "Введите телефон номер",
            "zhsn.required" =>"Введите ИИН",
            "zhsn.max" => "Максимальное количество 14"
        ];

        $validator = $this->validator($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());

        } else {
            $lastuser = User::orderBy('id','desc')->first();

            $user = new User;

            $user['status'] = 'registered';
            $user['login'] = 000000+$lastuser['id']+1;
            $user['password'] = $request['password'];

            $user['zhsn'] = $request['zhsn'];
            $user['phone'] = $request['phone'];
            $user['email'] = $request['email'];
            $user['status'] = 'partner';
            $user['name']  =$request['name'];
            $user['referBy'] = $request['referBy'];
            $user['bill'] = 0;

            $user->save();
            if ($request['referBy'] != null){
                $count = User::where('referBy',$request['referBy'])->count();

                if ($count>=3){
                    return back()->withErrors('Вся ячейки для приглашения заняты');

                }
            }
            if ($request['referBy'] == null){
                $this->AddUserToMatrix($user->id);
            }elseif($request['referBy'] != null){
                $this->AddReferToMatrix($user['id'],$request['referBy'],1);
            }


            return redirect()->route('Home')->with('message','Ваш запрос отправлен! Ваш логин:'.$user['login']);
        }
    }

    public function LoginPage(){
        return view('login');
    }

    public function Login(Request $request)
    {
        $rules = [
            'login' => 'required|max:255|exists:users,login',
            'password' => 'required|max:255',
        ];

        $messages = [
            "login.exists" => "Неверный логин",
        ];

        $validator = $this->validator($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());

        } else {
            $user = User::whereLogin($request['login'])->wherePassword($request['password'])->whereIn('status',['registered','partner'])->first();

            if (!$user){
                return redirect()->route('LoginPage')->withErrors('Логин или пароль не верно');
            }
            session()->put('user',$user);
            session()->save();

            return redirect()->route('Home');
        }
    }
    public function Edit(){
        $user= session()->get('user');

        $data['user'] = User::find($user['id']);

        return view('edit', $data);
    }
    public function Account(){
        $data['user'] = session()->get('user');

        return view('account',$data);
    }
    public function EditUser(Request $request){
        $data['user'] = session()->get('user');
        $rules = [
            'id'=>'required|max:255',
            'email' => 'required|max:255',
            'name' => 'required|max:255',
            'phone'  => 'required|max:14',
            'password' => 'required|max:14'

        ];
        $messages = [
            "id.required"=>"Введите id",
            "email.required" => "Введите email",
            "name.required" => "Введите ФИО",
            "phone.required" => "Введите телефон",
            "password.required" => "Введите пароль"
        ];
        $validator = $this->validator($request->all(), $rules, $messages);

        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }else{
            if($request['zhsn'] == 0){
            (new \App\Models\User)::where('id',$data['user']->id)->update($request->only(['password','email','name','phone']));
            }else{
            (new \App\Models\User)::where('id',$data['user']->id)->update($request->only(['password','zhsn','email','name','phone']));
            }




            return back()->with('message','Изменено');


        }



    }
    public function MessageSend(Request $request){
        $rules = [
            'question'  => 'required|max:255',
            'author' => 'required|max:255'

        ];
        $messages = [
            "question.required" => "Введите ваш вопрос",
            "author.required" => "Введите ваш аккаунт",
            "question.max" =>"Максимальное количество символов 255"
        ];
        $validator = $this->validator($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }else{

            $message = new Message;
            $message['question'] = $request['question'];

            $message['author'] =$request['author'];


            $message->save();

            return back()->with('message','Отправлено');


        }


    }
    public function MessagePage(){

        $data['user'] = session()->get('user');
        $user = $data['user'];

        $data['messages'] = Message::where('author',$user['login'])->where('answer','!=',NULL)->paginate(3);
        return view('message',$data);
    }
    public function Out(Request $request){
        session()->forget('user');
        return redirect()->route('LoginPage')->withErrors('Вы вышли');

    }

    public function Main(){
        $user = session()->get('user');
        $data['user'] = User::find($user['id']);
        $data['referBy'] = User::where('referBy',$user['id'])->count();
        $data['botCount'] = User::where('bot_owner_id',$user['id'])->count();


        $data['tree'] = Tree::whereUserId($data['user']->id)->first();

        return view('main',$data);
    }
    public function AddBot(Request $request){
        $rules = [
          'password' => 'required',

        ];
        $messages = [
          'password.required' => 'Введите пароль'
        ];
        $validator = $this->validator($request->all(),$rules,$messages);
        if ($validator->fails()){
            return back()->withErrors($validator->errors());
        }else{
            $users = Tree2::where('parents','LIKE','%'.$request['user_id'].'%')->get();
            $bots = User::where('bot_owner_id',$request['user_id'])->count();
            if($bots == 0){

                if(!empty($users[5])){
                    $user = User::where('id',$request['user_id'])->first();
                    $lastUser = User::orderBy('id','desc')->first();
                    $bot = new User();
                    $bot['status'] = 'partner';
                    $bot['name'] = $user['login'].'_bot_'.($lastUser['id']+1);
                    $bot['login'] = 00000+$lastUser['id']+1;
                    $bot['zhsn'] = $user['zhsn'];
                    $bot['phone'] = $user['phone'];
                    $bot['bill'] = 0;
                    $bot['password'] = $request['password'];
                    $bot['bot_owner_id'] = $request['user_id'];
                    $bot->save();
                    $this->AddReferToMatrix($bot['id'],$user['id'],2);
                }else{

                    return back()->withErrors('Бот будет доступен на 3 ряду');
                }
            }
            elseif ($bots ==1){
                if(!empty($users[13])){
                    $user = User::where('id',$request['user_id'])->first();
                    $lastUser = User::orderBy('id','desc')->first();
                    $bot = new User();
                    $bot['status'] = 'partner';
                    $bot['name'] = $user['login'].'_bot_'.($lastUser['id']+1);
                    $bot['login'] = 00000+$lastUser['id']+1;
                    $bot['zhsn'] = $user['zhsn'];
                    $bot['phone'] = $user['phone'];
                    $bot['bill'] = 0;
                    $bot['password'] = $request['password'];
                    $bot['bot_owner_id'] = $request['user_id'];
                    $bot->save();
                    $this->AddReferToMatrix($bot['id'],$user['id'],2);
                }else{

                    return back()->withErrors('Бот будет доступен на 3 ряду');
                }
            }
            elseif ($bots ==2){
                if(!empty($users[20])){
                    $user = User::where('id',$request['user_id'])->first();
                    $lastUser = User::orderBy('id','desc')->first();
                    $bot = new User();
                    $bot['status'] = 'partner';
                    $bot['name'] = $user['login'].'_bot_'.($lastUser['id']+1);
                    $bot['login'] = 00000+$lastUser['id']+1;
                    $bot['zhsn'] = $user['zhsn'];
                    $bot['phone'] = $user['phone'];
                    $bot['bill'] = 0;
                    $bot['password'] = $request['password'];
                    $bot['bot_owner_id'] = $request['user_id'];
                    $bot->save();
                    $this->AddReferToMatrix($bot['id'],$user['id'],2);
                }else{

                    return back()->withErrors('Бот будет доступен на 3 ряду');
                }
            }elseif($bots==4){
                return back()->withErrors('Максимальное количество ботов 4');
            }
        }
    }
    public function SecondTree($userId){

        $user = Tree2::join('users','users.id','tree2s.user_id')->
            select('tree2s.*','name','phone','login','email')->where('user_id',$userId)->first();

        $data['user'] = $user;
        $data['secondTree'] = 1;



        return view('tree',$data);

    }
    public function Tree($userId){

        $user = Tree::join('users','users.id','tree.user_id')
            ->select('tree.*','name','phone','login','email')->where('user_id',$userId)->first();
        $data['user'] = $user;




        if ($userId){

            $childUsers = Tree::where('parents','LIKE','%'.$user['id'].'%')->get();

            if (!empty($childUsers[61])){
                $data['exception'] = 1;
            }else{
                $data['exception'] = 0;
            }



        }else{
            $user = $user->first();
        }
        return view('tree',$data);
    }

}
