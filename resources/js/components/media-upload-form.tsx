import * as React from 'react';
import { useState, useRef, FormEvent } from 'react';
import { router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { X } from 'lucide-react';

const MAX_PHOTOS = 5;
const MIN_WIDTH = 800;
const MIN_HEIGHT = 600;

interface Preview {
    file: File;
    preview: string;
}

export default function MediaUploadForm() {
    const fileInputRef = useRef<HTMLInputElement>(null);
    const [mediaPreviews, setMediaPreviews] = useState<Preview[]>([]);
    const [imageErrors, setImageErrors] = useState<string[]>([]);
    const [collectionName, setCollectionName] = useState<string>('');

    // Validate image dimensions
    const validateImageDimensions = (file: File): Promise<boolean> => {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = () => {
                const isValid = img.naturalWidth >= MIN_WIDTH && img.naturalHeight >= MIN_HEIGHT;
                URL.revokeObjectURL(img.src);
                resolve(isValid);
            };
            img.onerror = () => resolve(false);
            img.src = URL.createObjectURL(file);
        });
    };

    const onFileChange = async (event: React.ChangeEvent<HTMLInputElement>) => {
        const files = event.target.files;
        if (!files) return;

        const errors: string[] = [];
        const newPreviews: Preview[] = [];

        for (const file of Array.from(files)) {
            if (mediaPreviews.length + newPreviews.length >= MAX_PHOTOS) {
                errors.push(`You can only upload up to ${MAX_PHOTOS} photos.`);
                break;
            }
            if (!file.type.startsWith('image/')) {
                errors.push(`File ${file.name} is not an image.`);
                continue;
            }
            const validSize = await validateImageDimensions(file);
            if (!validSize) {
                errors.push(`Image ${file.name} dimensions must be at least ${MIN_WIDTH}x${MIN_HEIGHT}px.`);
                continue;
            }
            const url = URL.createObjectURL(file);
            newPreviews.push({ file, preview: url });
        }

        setImageErrors(errors);
        if (newPreviews.length) {
            setMediaPreviews((prev) => [...prev, ...newPreviews]);
        }
        if (fileInputRef.current) {
            fileInputRef.current.value = '';
        }
    };

    const removePhoto = (idx: number) => {
        setMediaPreviews((prev) => {
            const copy = [...prev];
            URL.revokeObjectURL(copy[idx].preview);
            copy.splice(idx, 1);
            return copy;
        });
    };

    const resetAll = () => {
        mediaPreviews.forEach((p) => URL.revokeObjectURL(p.preview));
        setMediaPreviews([]);
        setImageErrors([]);
        setCollectionName('');
        if (fileInputRef.current) fileInputRef.current.value = '';
    };

    const upload = (e: FormEvent) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('collection_name', collectionName);
        mediaPreviews.forEach((p) => formData.append('images[]', p.file));

        router.post('/settings/media', formData, {
            preserveScroll: true,
            onSuccess: () => resetAll(),
            onError: (errors: Record<string, string>) => {
                const msgs = Object.values(errors);
                setImageErrors(msgs);
            },
        });
    };

    const canUpload = mediaPreviews.length > 0 && collectionName.trim() !== '';

    return (
        <form onSubmit={upload} encType="multipart/form-data" className="space-y-4">
            <h2 className="text-lg font-semibold text-gray-900 dark:text-neutral-200">
                Upload Media
            </h2>
            <div className="grid w-full max-w-sm items-center gap-1.5">
                <Label htmlFor="collection_name">Collection name</Label>
                <Input
                    id="collection_name"
                    name="collection_name"
                    type="text"
                    value={collectionName}
                    onChange={(e) => setCollectionName(e.target.value)}
                    placeholder="Enter collection name"
                />
            </div>

            <div>
                <Label className="block mb-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
                    Add photos (max {MAX_PHOTOS})
                </Label>
                <div className="flex flex-wrap gap-2">
                    <label
                        htmlFor="media"
                        className="flex shrink-0 justify-center items-center w-32 h-32 border-2 border-dotted border-gray-300 rounded-xl text-gray-400 cursor-pointer hover:bg-gray-50 dark:border-neutral-700 dark:text-neutral-600 dark:hover:bg-neutral-700/20"
                    >
                        <input
                            ref={fileInputRef}
                            id="media"
                            type="file"
                            accept="image/*"
                            multiple
                            className="hidden"
                            onChange={onFileChange}
                            disabled={mediaPreviews.length >= MAX_PHOTOS}
                        />
                        <svg
                            className="w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            strokeWidth={1.5}
                        >
                            <path strokeLinecap="round" strokeLinejoin="round" d="M5 12h14M12 5v14" />
                        </svg>
                    </label>

                    {mediaPreviews.map((mp, idx) => (
                        <div
                            key={mp.preview}
                            className="relative w-32 h-32 rounded-xl overflow-hidden border border-gray-300 dark:border-neutral-700"
                        >
                            <img
                                src={mp.preview}
                                className="object-cover w-full h-full"
                                alt="preview"
                            />
                            <button
                                type="button"
                                onClick={() => removePhoto(idx)}
                                className="absolute top-1 right-1 p-1 bg-white rounded-full dark:bg-neutral-800"
                            >
                                <X className="w-4 h-4 text-gray-500 dark:text-neutral-400" />
                            </button>
                        </div>
                    ))}
                </div>
                <p className="mt-2 text-xs text-gray-500 dark:text-neutral-500">
                    Shoppers find images more helpful than text alone.
                </p>
            </div>

            {imageErrors.length > 0 && (
                <div className="text-red-500 text-sm">
                    {imageErrors.map((error, i) => (
                        <div key={i}>{error}</div>
                    ))}
                </div>
            )}

            <div className="flex mt-4">
                <Button
                    type="submit"
                    className="btn-outline disabled:opacity-25 disabled:cursor-not-allowed"
                    disabled={!canUpload}
                >
                    Upload
                </Button>
                <Button
                    type="button"
                    variant="outline"
                    className="ml-4"
                    onClick={resetAll}
                >
                    Reset
                </Button>
            </div>
        </form>
    );
}
