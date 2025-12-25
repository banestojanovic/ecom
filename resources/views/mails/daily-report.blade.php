<x-mail::message>
# Daily Report of sold products

<x-mail::table>
| Product Name       | Quantity Sold | Total Revenue |
| ------------------ | ------------- | ------------- |
@foreach ($products as $product)
| {{ $product['product']->name }} | {{ $product['quantity'] }} | ${{ number_format($product['total_revenue'], 2) }} |
@endforeach
</x-mail::table>

**Total Revenue:** ${{ number_format($revenue, 2) }}
</x-mail::message>
