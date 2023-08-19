<?php 

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;


Breadcrumbs::for('/', function($trail){
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('products', function($trail){
    $trail->parent('/');
    $trail->push('Products', route('products'));
});

Breadcrumbs::for('products.view', function($trail, $product){
    $trail->parent('/');
    $trail->push('Products', route('products'));
    $trail->push($product->title, route('product.view', $product->slug));
});

Breadcrumbs::for('pages', function($trail, $page){
    $trail->parent('/');
    $trail->push($page->title);
});

Breadcrumbs::for('categories', function($trail){
    $trail->parent('/');
    $trail->push('Categories', route('categories'));
});

Breadcrumbs::for('categories.view', function($trail, $catTitle){
    $trail->parent('/');
    $trail->push('Categories', route('categories'));
    $trail->push($catTitle);
});

Breadcrumbs::for('cart', function($trail){
    $trail->parent('/');
    $trail->push('Cart', route('cart.index'));
});


// For user login

Breadcrumbs::for('profile', function($trail){
    $trail->parent('/');
    $trail->push('Profile', route('profile'));
});

Breadcrumbs::for('orders', function($trail){
    $trail->parent('/');
    $trail->push('Orders', route('order.index'));
});

Breadcrumbs::for('orders.view', function($trail, $order){
    $trail->parent('/');
    $trail->push('Orders', route('order.index'));
    $trail->push($order->id);
});