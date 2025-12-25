import { update } from '@/routes/cart';
import { Product as ProductInterface } from '@/types';
import { useForm } from '@inertiajs/react';
import QuantityInputBasic from '../../../components/commerce-ui/quantity-input-basic';

export default function ProductItemQtyInput({ item }: { item: any }) {
    const product = item.product as ProductInterface;
    const { post, processing } = useForm({
        product_id: product.id,
    });

    const changeQty = (newQuantity: number) => {
        let type = '';
        if (item.quantity < newQuantity) {
            type = 'increment';
        } else if (item.quantity > newQuantity) {
            type = 'decrement';
        }
        post(update({ type }).url, {
            onSuccess: () => {
                type = '';
            },
        });
    };

    return (
        <div>
            <QuantityInputBasic
                quantity={item.quantity}
                disabled={processing}
                onChange={changeQty}
            />
        </div>
    );
}
