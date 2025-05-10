// src/hooks/usePhotoUrl.ts

import { useCallback } from 'react';

/**
 * React hook to normalize photo URLs for avatars and other media.
 *
 * @returns {{ getPhotoUrl: (url?: string | null) => string }}
 */
export function usePhotoUrl() {
    const defaultAvatar = '/images/default-avatar.png';

    /**
     * Return a valid <img> src based on the given url.
     * - If url is falsy, returns a default avatar.
     * - If url is already an absolute HTTP(s) URL or a data URI, returns it unchanged.
     * - Otherwise, treats it as a path relative to /storage.
     *
     * @param url The stored URL or path of the image.
     */
    const getPhotoUrl = useCallback((url?: string | null): string => {
        if (!url) {
            return defaultAvatar;
        }

        if (url.startsWith('http') || url.startsWith('data:image')) {
            return url;
        }

        // Strip leading slash if present, then prefix with /storage/
        const relativePath = url.startsWith('/') ? url.slice(1) : url;
        return `/storage/${relativePath}`;
    }, []);

    return { getPhotoUrl };
}
