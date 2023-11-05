<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use App\Rules\RecaptchaRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminFlashSaleController extends Controller
{
    public function edit(): Response|ResponseFactory
    {
        $flashSale = FlashSale::findOrFail(1);

        $products = Product::select('id', 'name')->whereStatus('approved')->get();

        $flashSaleItems = FlashSaleItem::with('product')->where('flash_sale_id', $flashSale->id)->paginate(10);

        return inertia('Admin/FlashSales/Edit', compact('flashSale', 'products', 'flashSaleItems'));
    }

    public function update(Request $request, FlashSale $flashSale): RedirectResponse
    {
        $request->validate([
            'end_date' => ['nullable', 'date'],
            'captcha_token' => ['required', new RecaptchaRule()],
        ]);

        $flashSale->update(['end_date' => $request->end_date]);

        return back()->with('success', 'FLASH_SALE_HAS_BEEN_SUCCESSFULLY_UPDATED');
    }

    public function addFlashSaleProduct(Request $request): RedirectResponse
    {
        FlashSaleItem::firstOrCreate(
            [
                'flash_sale_id' => 1,
                'product_id' => $request->product_id,
            ],
            [
                'flash_sale_id' => 1,
                'product_id' => $request->product_id,
            ]
        );

        return back()->with('success', 'FLASH_SALE_PRODUCT_HAS_BEEN_SUCCESSFULLY_ADDED');
    }

    public function removeFlashSaleProduct(int $flashSaleProductId): RedirectResponse
    {
        $flashSaleItem = FlashSaleItem::where('product_id', $flashSaleProductId)->first();

        if ($flashSaleItem) {
            $flashSaleItem->delete();
        }

        return back()->with('success', 'FLASH_SALE_PRODUCT_HAS_BEEN_SUCCESSFULLY_REMOVED');
    }
}
