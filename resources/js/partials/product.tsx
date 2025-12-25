import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { add } from '@/routes/cart';
import { Product as ProductInterface } from '@/types';
import { useForm } from '@inertiajs/react';

export default function Product({ product }: { product: ProductInterface }) {
    const { post, processing } = useForm({
        product_id: product.id,
        quantity: 1,
    });

    const addToCart = () => {
        post(add().url);
    };

    return (
        <div className="rounded-sm border border-[#19140035] p-4 dark:border-[#3E3E3A]">
            <h2 className="text-lg font-semibold">{product.name}</h2>
            <p className="mt-2 text-sm text-[#555551] dark:text-[#A3A3A0]">
                {product.description}
            </p>
            <p className="mt-4 font-bold">${product.price.toFixed(2)}</p>

            <div
                className={`mt-4 border-t border-[#19140035] pt-4 dark:border-[#3E3E3A]`}
            >
                {product?.stock && product.stock > 0 ? (
                    <div className={`flex items-center justify-between`}>
                        <span className="text-sm font-medium text-green-600 dark:text-green-400">
                            In Stock
                        </span>

                        <div>
                            <Button
                                type={`button`}
                                disabled={processing}
                                onClick={addToCart}
                            >
                                {processing && <Spinner />}
                                <span>Add to cart</span>
                            </Button>
                        </div>
                    </div>
                ) : (
                    <span className="text-sm font-medium text-red-600 dark:text-red-400">
                        Out of Stock
                    </span>
                )}
            </div>
        </div>
    );
}
