"use client"

import * as React from "react"
import { format } from "date-fns"
import { CalendarIcon } from "lucide-react"

import { cn } from "@/lib/utils" // Assurez-vous que ce chemin est correct pour votre projet
import { Button } from "@/components/ui/button" // Assurez-vous que ce chemin est correct
import { Calendar } from "@/components/ui/calendar" // Assurez-vous que ce chemin est correct
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover" // Assurez-vous que ce chemin est correct

/**
 * Reusable DatePicker component wrapped in a Popover.
 *
 * Props:
 * - value: the selected Date or undefined
 * - onChange: callback when a new date is selected
 * - placeholder: text when no date is selected
 * - format: date-fns format string (default "PPP")
 * - buttonClassName: additional classes for the trigger button
 * - popoverClassName: additional classes for the popover content
 */
export interface DatePickerProps {
    value?: Date
    onChange: (date: Date) => void // Attend une Date valide, pas undefined
    placeholder?: string
    format?: string
    buttonClassName?: string
    popoverClassName?: string
}

export function DatePicker({
    value,
    onChange,
    placeholder = "Pick a date", // Texte à afficher si aucune date n'est sélectionnée
    format: displayFormat = "PPP", // Format d'affichage de la date (via date-fns)
    buttonClassName,
    popoverClassName,
}: DatePickerProps) {
    const [open, setOpen] = React.useState(false)

    return (
        <Popover open={open} onOpenChange={setOpen}>
            <PopoverTrigger asChild>
                <Button
                    variant="outline"
                    className={cn(
                        "w-full justify-start text-left font-normal",
                        !value && "text-muted-foreground",
                        buttonClassName
                    )}
                >
                    <CalendarIcon className="mr-2 h-4 w-4" />
                    {value ? format(value, displayFormat) : <span>{placeholder}</span>}
                </Button>
            </PopoverTrigger>
            <PopoverContent className={cn("w-auto p-0", popoverClassName)}>
                <Calendar
                    mode="single"
                    selected={value}
                    onSelect={(selectedDate: Date | undefined) => {
                        // La fonction `onChange` attend un argument de type `Date`.
                        // `selectedDate` provenant de `onSelect` peut être `undefined`.
                        // Nous nous assurons que `selectedDate` est bien une `Date` avant d'appeler `onChange`.
                        if (selectedDate) {
                            onChange(selectedDate);
                        }
                        // On ferme le Popover que la date soit définie ou non,
                        // car l'interaction avec le calendrier est terminée.
                        setOpen(false);
                    }}
                    initialFocus
                />
            </PopoverContent>
        </Popover>
    )
}
