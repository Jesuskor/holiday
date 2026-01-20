export interface Reservation {
    id: number,
    hotel: string;
    guest_name: string;
    check_in_date: string;
    check_out_date: string;
    total_price: number;
    status: string;
}
