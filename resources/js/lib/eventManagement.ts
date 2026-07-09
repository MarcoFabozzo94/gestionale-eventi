export function formatEuro(cents: number): string {
    return new Intl.NumberFormat('it-IT', {
        style: 'currency',
        currency: 'EUR',
    }).format(cents / 100);
}

export function formatDate(date: string | null): string {
    if (!date) {
        return '-';
    }

    return new Intl.DateTimeFormat('it-IT', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(`${date}T00:00:00`));
}

export function centsToEuros(cents: number): string {
    return (cents / 100).toFixed(2);
}

export function marginClass(cents: number): string {
    return cents >= 0 ? 'text-[var(--fluo-lime)]' : 'text-[var(--fluo-red)]';
}
