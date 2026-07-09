export interface DashboardMetrics {
    events_count: number;
    staff_count: number;
    sold_total_cents: number;
    staff_cost_total_cents: number;
    margin_total_cents: number;
}

export interface EventSummary {
    id: number;
    title: string;
    event_date: string;
    location: string;
    client_name: string | null;
    sold_price_cents: number;
    staff_cost_cents?: number;
    margin_cents?: number;
    assignments_count?: number;
    notes?: string | null;
}

export interface StaffMemberSummary {
    id: number;
    first_name: string;
    last_name: string;
    name: string;
    email: string | null;
    phone: string | null;
    is_active: boolean;
    notes: string | null;
    assignments_count: number;
    total_earned_cents: number;
}

export interface StaffRoleSummary {
    id: number;
    name: string;
    description: string | null;
    is_active: boolean;
    assignments_count?: number;
}

export interface EventAssignment {
    id: number;
    staff_member_id: number;
    staff_member_name: string;
    staff_role_id: number;
    staff_role_name: string;
    compensation_cents: number;
    notes: string | null;
}

export interface SelectOption {
    id: number;
    name: string;
}

export interface StaffHistoryItem {
    id: number;
    event_id: number;
    event_title: string;
    event_date: string;
    location: string;
    role_name: string;
    compensation_cents: number;
}
