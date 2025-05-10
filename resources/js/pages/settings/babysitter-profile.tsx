import { Head, useForm } from '@inertiajs/react';
import React, { FormEventHandler } from 'react';

import HeadingSmall from '@/components/heading-small';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import InputError from '@/components/input-error';

import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Button } from '@/components/ui/button';
import { ToggleGroup, ToggleGroupItem } from '@/components/ui/toggle-group';
import { DatePicker } from '@/components/date-picker';
import {
    Calendar1,
    Clock,
    CalendarDays,
    CalendarCheck,
    CalendarSync,
    LoaderCircle,
    SaveIcon,
} from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile Details',
        href: '/settings/babysitter/profile/details',
    },
];

export interface BabysitterProfileData {
    first_name: string;
    last_name: string;
    birthdate: string;
    phone: string;
    bio: string;
    experience: string;
    price_per_hour: string;
    payment_frequency: 'daily' | 'per_task' | 'weekly' | 'biweekly' | 'monthly';
    [key: string]: string;
}

export default function BabysitterProfile() {
    const { data, setData, patch, errors, reset, processing } = useForm<BabysitterProfileData>({
        first_name: '',
        last_name: '',
        birthdate: '',
        phone: '',
        bio: '',
        experience: '',
        price_per_hour: '',
        payment_frequency: 'daily',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        patch(route('settings.babysitter.profile.update'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Profile Details" />
            <SettingsLayout>
                <div className="max-w-3xl mx-auto p-4 sm:p-6">
                    <HeadingSmall title="Profile Information" description="Update your personal details" />

                    <form onSubmit={submit} className="mt-6 space-y-6">
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {/* Payment Frequencies full width */}
                            <div className="sm:col-span-2">
                                <Label htmlFor="payment_frequency_group" className="mb-2">
                                    Payment Frequencies
                                </Label>
                                <ToggleGroup
                                    id="payment_frequency_group"
                                    type="single"
                                    className="w-full"
                                    value={data.payment_frequency}
                                    onValueChange={(value) => setData('payment_frequency', value as any)}
                                    variant="outline"
                                >
                                    <ToggleGroupItem value="per_task">
                                        <Calendar1 className="h-4 w-4 mr-2" /> Per task
                                    </ToggleGroupItem>
                                    <ToggleGroupItem value="daily">
                                        <Clock className="h-4 w-4 mr-2" /> Daily
                                    </ToggleGroupItem>
                                    <ToggleGroupItem value="weekly">
                                        <CalendarDays className="h-4 w-4 mr-2" /> Weekly
                                    </ToggleGroupItem>
                                    <ToggleGroupItem value="biweekly">
                                        <CalendarCheck className="h-4 w-4 mr-2" /> Biweekly
                                    </ToggleGroupItem>
                                    <ToggleGroupItem value="monthly">
                                        <CalendarSync className="h-4 w-4 mr-2" /> Monthly
                                    </ToggleGroupItem>
                                </ToggleGroup>
                                <InputError message={errors.payment_frequency} className="mt-2" />
                            </div>

                            {/* First Name */}
                            <div>
                                <Label htmlFor="first_name">First Name</Label>
                                <Input
                                    id="first_name"
                                    value={data.first_name}
                                    onChange={(e) => setData('first_name', e.target.value)}
                                    className="mt-1 w-full"
                                />
                                <InputError message={errors.first_name} className="mt-1" />
                            </div>

                            {/* Last Name */}
                            <div>
                                <Label htmlFor="last_name">Last Name</Label>
                                <Input
                                    id="last_name"
                                    value={data.last_name}
                                    onChange={(e) => setData('last_name', e.target.value)}
                                    className="mt-1 w-full"
                                />
                                <InputError message={errors.last_name} className="mt-1" />
                            </div>

                            {/* Phone */}
                            <div>
                                <Label htmlFor="phone">Phone</Label>
                                <Input
                                    id="phone"
                                    value={data.phone}
                                    onChange={(e) => setData('phone', e.target.value)}
                                    className="mt-1 w-full"
                                />
                                <InputError message={errors.phone} className="mt-1" />
                            </div>

                            {/* Birthdate */}
                            <div>
                                <Label htmlFor="birthdate" className="mb-2">
                                    Birthdate
                                </Label>
                                <DatePicker
                                    value={data.birthdate ? new Date(data.birthdate) : undefined}
                                    onChange={(date) => setData('birthdate', date?.toISOString().split('T')[0] || '')}
                                    placeholder="Select birthdate"
                                    format="yyyy-MM-dd"
                                />
                                <InputError message={errors.birthdate} className="mt-1" />
                            </div>

                            {/* Bio full width */}
                            <div className="sm:col-span-2">
                                <Label htmlFor="bio">Bio</Label>
                                <Textarea
                                    id="bio"
                                    rows={4}
                                    value={data.bio}
                                    onChange={(e) => setData('bio', e.target.value)}
                                    className="mt-1 w-full"
                                />
                                <InputError message={errors.bio} className="mt-1" />
                            </div>

                            {/* Experience full width */}
                            <div className="sm:col-span-2">
                                <Label htmlFor="experience">Experience</Label>
                                <Textarea
                                    id="experience"
                                    rows={3}
                                    value={data.experience}
                                    onChange={(e) => setData('experience', e.target.value)}
                                    className="mt-1 w-full"
                                />
                                <InputError message={errors.experience} className="mt-1" />
                            </div>

                            {/* Price per hour */}
                            <div className="sm:col-span-2">
                                <Label htmlFor="price_per_hour">Price per hour</Label>
                                <Input
                                    id="price_per_hour"
                                    type="number"
                                    value={data.price_per_hour}
                                    onChange={(e) => setData('price_per_hour', e.target.value)}
                                    className="mt-1 w-full"
                                />
                                <InputError message={errors.price_per_hour} className="mt-1" />
                            </div>
                        </div>

                        {/* Action Button */}
                        <div className="flex flex-col">
                            <Button type="submit" className="w-full mt-4" disabled={processing}>
                                {processing ? (
                                    <LoaderCircle className="h-4 w-4 animate-spin mr-2" />
                                ) : (
                                    <SaveIcon className="h-4 w-4 mr-2" />
                                )}
                                Enregistrer les modifications
                            </Button>
                        </div>
                    </form>
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
