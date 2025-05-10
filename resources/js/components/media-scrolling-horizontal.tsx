import * as React from 'react';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { usePhotoUrl } from '@/hooks/use-photo-url';
import { Button } from './ui/button';
import { router } from '@inertiajs/react';

export interface MediaItem {
    id: number;
    url: string;
    collection_name: string;
    mime_type: string;
    is_profile: boolean;
}

export interface MediaScrollingHorizontalProps {
    items: MediaItem[];
}

export default function MediaScrollingHorizontal({
    items,
}: MediaScrollingHorizontalProps) {
    const { getPhotoUrl } = usePhotoUrl();

    /**
     * Send a request to the server to set this media item as the user's profile photo.
     * @param media The media item to set as profile photo.
     */
    const handleSetProfile = (media: MediaItem) => {
        router.post('/settings/media/setAsProfile', { media_id: media.id }, {
            preserveScroll: true,
            onSuccess: () => {
                console.log(`Profile photo updated: ${media.id}`);
            },
            onError: (errors) => {
                console.error('Failed to set profile photo:', errors);
            },
        });
    };

    /**
     * Send a request to the server to delete this media item.
     * @param media The media item to delete.
     */
    const handleDelete = (media: MediaItem) => {
        router.delete(`/settings/media/${media.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                console.log(`Media deleted: ${media.id}`);
            },
            onError: (errors) => {
                console.error('Failed to delete media:', errors);
            },
        });
    };
    if (items.length === 0) {
        return <p className="p-4 text-sm text-muted-foreground">No media uploaded yet.</p>;
    }

    return (
        <ScrollArea className="w-full whitespace-nowrap rounded-md border">
            <div className="flex w-max space-x-4 p-4">
                {items.map((media) => (
                    <figure key={media.id} className="shrink-0">
                        {/* Thumbnail container with fixed dimensions */}
                        <div className="overflow-hidden rounded-md w-84">
                            <img
                                src={getPhotoUrl(media.url)}
                                alt={`${media.collection_name} #${media.id}`}
                                className="aspect-[3/4] h-fit w-fit object-cover"
                                loading="lazy"
                            />
                        </div>
                        <figcaption className="pt-2 text-xs text-muted-foreground">
                            Photo de{" "}
                            <span className="font-semibold text-foreground">
                                {media.is_profile
                                    ? 'Profile'
                                    : media.collection_name === 'garde'
                                        ? ' la Collection de Garde '
                                        : media.collection_name}
                            </span>
                        </figcaption>
                        {!media.is_profile  && (
                            <figcaption className="flex justify-between items-center w-full pt-2 text-xs text-muted-foreground">
                                <Button onClick={() => handleSetProfile(media)}>
                                    Mettre en profile
                                </Button>
                                <Button
                                    variant="destructive"
                                    className="ml-2"
                                    onClick={() => handleDelete(media)}
                                >
                                    Supprimer
                                </Button>
                            </figcaption>
                        )}

                    </figure>
                ))}
            </div>
            <ScrollBar orientation="horizontal" />
        </ScrollArea>
    );
}
