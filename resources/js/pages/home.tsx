import AppLayout from '@/pages/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { ReactNode } from 'react';
import Product from '@/partials/product';
import { Product as ProductInterface } from '@/types';

const Home = ({ products }: { products: ProductInterface[]; }) => {
    return (
        <>
            <Head title="eCommerce Application" />

            <div>
                <h1 className={`text-foreground dark:text-foreground text-2xl font-semibold`}>Find the best products</h1>

                <div className={`mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4`}>
                    {products?.data?.map((product: ProductInterface) => (
                        <Product key={product.id} product={product} />
                    ))}
                </div>
            </div>
        </>
    );
};

Home.layout = (page: ReactNode) => <AppLayout>{page}</AppLayout>;

export default Home;
