import { Toaster } from '@/components/ui/sonner';
import { useEffect } from 'react';
import { toast } from 'sonner';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/react';

export default function FlashedMessages() {
    const {flash} = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) {
            toast.success('Success', {
                description: flash.success,
            });
        }

        if (flash?.error) {
            toast.error('Error', {
                description: flash.error,
            });
        }
    }, [flash]);

    return <Toaster position={`bottom-center`} />;
}
