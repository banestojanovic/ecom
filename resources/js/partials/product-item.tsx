import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { remove } from '@/routes/cart';
import { Product as ProductInterface } from '@/types';
import { useForm } from '@inertiajs/react';
import { LucideTrash2 } from 'lucide-react';
import ProductItemQtyInput from '@/partials/product-item-qty-input';

export default function ProductItem({
    item,
}: {
    item: any;
}) {
    const product = item.product as ProductInterface;
    const { post, processing } = useForm({
        product_id: product.id,
    });

    const removeFromCart = () => {
        post(remove().url);
    };

    return (
        <div className="">
            <div className={`flex justify-between`}>
                <div>
                    <h2 className="text-lg font-semibold">{product.name}</h2>
                    <p className="mt-4 font-bold">
                        {`${product.price.toFixed(2)} x ${item.quantity}`}
                    </p>
                    <span className="mt-2 text-sm text-[#555551] dark:text-[#A3A3A0]">
                        {`${product.stock} in stock`}
                    </span>
                </div>

                <div className={`flex flex-col items-end gap-2`}>
                    <div>
                        <Button
                            type={`button`}
                            disabled={processing}
                            variant={`destructive`}
                            size={`sm`}
                            onClick={removeFromCart}
                        >
                            {processing ? <Spinner /> : <LucideTrash2 />}
                        </Button>
                    </div>

                    <div>
                        <ProductItemQtyInput item={item} />
                    </div>
                </div>
            </div>
        </div>
    );
}
