import { Head } from '@inertiajs/react';
import HeadingSmall from '@/components/heading-small';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import MediaScrolllingHorizontal from '@/components/media-scrolling-horizontal';
import MediaUploadForm from '@/components/media-upload-form';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Media settings',
        href: '/settings/media',
    },
];

export default function Media({ media }: {
    media: Array<{
        id: number;
        url: string;
        collection_name: string;
        mime_type: string;
        is_profile: boolean;
    }>
}) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Media settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall
                        title="Media settings"
                        description="Manage your uploaded media here"
                    />
                    <p className="text-sm text-muted-foreground">
                        You can upload images, videos, and other media files here. You can also set a profile photo.
                    </p>
                    <p className="text-sm text-muted-foreground">
                        You can upload up to 5 images at a time. The maximum file size is 5MB per image.
                    </p>

                    <MediaUploadForm />
                    <MediaScrolllingHorizontal items={media} />
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
