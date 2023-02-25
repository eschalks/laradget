export interface PaginatedResponse<T> {
    data: T[];
    links: {
        url: string;
        label: string;
        active: boolean;
    }
}
