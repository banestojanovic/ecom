import { Button } from '@/components/ui/button';
import FlashedMessages from '@/components/ui/flash-messages';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';
import { Spinner } from '@/components/ui/spinner';
import ProductItem from '@/partials/product-item';
import { dashboard, login, register } from '@/routes';
import { store } from '@/routes/order';
import { Cart, type SharedData } from '@/types';
import { Link, useForm, usePage } from '@inertiajs/react';
import { LucideShoppingCart } from 'lucide-react';
import { type PropsWithChildren, useState } from 'react';

export default function AppLayout({ children }: PropsWithChildren) {
    const { auth, canRegister, cart, total } = usePage<SharedData>().props;
    const cartItemsCount = (cart as Cart)?.items?.length || 0;
    const [openCart, setOpenCart] = useState<boolean>(false);

    const { post, processing } = useForm({});

    const createOrder = () => {
        post(store().url, {
            onSuccess: () => {
                setOpenCart(false);
            },
        });
    };

    return (
        <div className="flex flex-col">
            <header className="container mx-auto mb-6 flex h-24 w-full items-center justify-between text-sm max-lg:px-4">
                <div className={`text-xl font-medium`}>
                    eCommerce application
                </div>
                <nav className="flex items-center justify-end gap-4">
                    {auth.user ? (
                        <>
                            <Link
                                href={dashboard()}
                                className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                            >
                                Dashboard
                            </Link>
                            <Button
                                type={`button`}
                                size={`icon`}
                                variant={`ghost`}
                                className={`relative`}
                                onClick={() => setOpenCart(true)}
                            >
                                {cartItemsCount > 0 && (
                                    <span
                                        className="absolute -top-2 -right-2 inline-flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-xs font-semibold text-white"
                                        aria-label={`${cartItemsCount} items in cart`}
                                    >
                                        {cartItemsCount}
                                    </span>
                                )}
                                <LucideShoppingCart strokeWidth={1.25} />
                            </Button>
                        </>
                    ) : (
                        <>
                            <Link
                                href={login()}
                                className="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                            >
                                Log in
                            </Link>
                            {canRegister && (
                                <Link
                                    href={register()}
                                    className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                                >
                                    Register
                                </Link>
                            )}
                        </>
                    )}
                </nav>
            </header>

            <main className="container mx-auto max-lg:px-4">{children}</main>

            <Sheet open={openCart} onOpenChange={(open) => setOpenCart(open)}>
                <SheetContent className={`overflow-y-auto`}>
                    <SheetHeader>
                        <SheetTitle>Your Shopping Cart</SheetTitle>
                        <SheetDescription>
                            Review your items and proceed to checkout.
                        </SheetDescription>
                    </SheetHeader>
                    <div className="grid flex-1 auto-rows-min gap-6 px-4">
                        {cart?.items && cart.items.length === 0 && (
                            <p>Your cart is currently empty.</p>
                        )}
                        {cart?.items &&
                            cart.items.length > 0 &&
                            cart.items.map((item) => (
                                <ProductItem key={item.id} item={item} />
                            ))}
                    </div>
                    <SheetFooter>
                        {total > 0 && (
                            <div
                                className={`my-4 flex flex-col gap-2 border-t border-dashed py-4`}
                            >
                                <h5>Order summary</h5>

                                <div>
                                    <div className="flex justify-between font-bold">
                                        <span>Total</span>
                                        <span>${total.toFixed(2)}</span>
                                    </div>
                                </div>
                            </div>
                        )}

                        {cart?.items && cart.items.length > 0 && (
                            <Button
                                type={`button`}
                                variant={`outline`}
                                size={`lg`}
                                className={`font-semibold tracking-wider uppercase`}
                                disabled={processing}
                                onClick={createOrder}
                            >
                                {processing && <Spinner />}
                                <span>Order now!</span>
                            </Button>
                        )}
                    </SheetFooter>
                </SheetContent>
            </Sheet>

            <FlashedMessages />
        </div>
    );
}
