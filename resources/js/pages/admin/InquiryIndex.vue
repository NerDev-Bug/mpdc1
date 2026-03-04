<template>
    <AdminLayout title="Inquiries">
        <!-- Header with stats -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900">All Inquiries</h3>
            <p class="text-sm text-gray-500">View and manage all submissions from the website.</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-2xl font-bold text-gray-900">{{ serviceInquiries.length }}</p>
                <p class="text-xs text-gray-500 mt-1">Service Residence</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-2xl font-bold text-gray-900">{{ privateInquiries.length }}</p>
                <p class="text-xs text-gray-500 mt-1">Private Residence</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-2xl font-bold text-gray-900">{{ contactSubmissions.length }}</p>
                <p class="text-xs text-gray-500 mt-1">Contact Us</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-2xl font-bold text-gray-900">{{ bookingRequests.length }}</p>
                <p class="text-xs text-gray-500 mt-1">Partner / Broker</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px overflow-x-auto">
                    <button v-for="tab in tabs" :key="tab.key"
                        @click="activeTabKey = tab.key"
                        class="whitespace-nowrap px-6 py-3 text-sm font-medium border-b-2 transition-colors"
                        :class="activeTabKey === tab.key
                            ? 'border-gray-900 text-gray-900'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    >
                        {{ tab.label }}
                        <span class="ml-1.5 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-medium"
                            :class="activeTabKey === tab.key ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600'">
                            {{ tab.count }}
                        </span>
                    </button>
                </nav>
            </div>

            <!-- Service Residence Inquiries -->
            <div v-if="activeTabKey === 'service'" class="overflow-x-auto">
                <table v-if="serviceInquiries.length" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in serviceInquiries" :key="item.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.first_name }} {{ item.last_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.contact }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.unit_type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ item.message || '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ formatDate(item.created_at) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button @click="viewDetail(item, 'service')" class="text-gray-400 hover:text-gray-600 mr-2" title="View">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </button>
                                <button @click="confirmDelete(item.id, 'service')" class="text-red-400 hover:text-red-600" title="Delete">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-else class="p-12 text-center text-sm text-gray-400">No service residence inquiries yet.</div>
            </div>

            <!-- Private Residence Inquiries -->
            <div v-if="activeTabKey === 'private'" class="overflow-x-auto">
                <table v-if="privateInquiries.length" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in privateInquiries" :key="item.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.first_name }} {{ item.last_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.contact }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.unit_type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ item.message || '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ formatDate(item.created_at) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button @click="viewDetail(item, 'private')" class="text-gray-400 hover:text-gray-600 mr-2" title="View">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </button>
                                <button @click="confirmDelete(item.id, 'private')" class="text-red-400 hover:text-red-600" title="Delete">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-else class="p-12 text-center text-sm text-gray-400">No private residence inquiries yet.</div>
            </div>

            <!-- Contact Us Submissions -->
            <div v-if="activeTabKey === 'contacts'" class="overflow-x-auto">
                <table v-if="contactSubmissions.length" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobile</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in contactSubmissions" :key="item.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.first_name }} {{ item.last_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ item.inquiry_type }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.country_code }} {{ item.mobile }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.project }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ formatDate(item.created_at) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button @click="viewDetail(item, 'contacts')" class="text-gray-400 hover:text-gray-600 mr-2" title="View">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </button>
                                <button @click="confirmDelete(item.id, 'contacts')" class="text-red-400 hover:text-red-600" title="Delete">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-else class="p-12 text-center text-sm text-gray-400">No contact submissions yet.</div>
            </div>

            <!-- Booking / Partner Requests -->
            <div v-if="activeTabKey === 'bookings'" class="overflow-x-auto">
                <table v-if="bookingRequests.length" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in bookingRequests" :key="item.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.first_name }} {{ item.last_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.contact_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ formatDate(item.date) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ item.time }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ formatDate(item.created_at) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button @click="viewDetail(item, 'bookings')" class="text-gray-400 hover:text-gray-600 mr-2" title="View">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </button>
                                <button @click="confirmDelete(item.id, 'bookings')" class="text-red-400 hover:text-red-600" title="Delete">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-else class="p-12 text-center text-sm text-gray-400">No booking requests yet.</div>
            </div>
        </div>

        <!-- View Detail Modal -->
        <div v-if="showDetailModal" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="showDetailModal = false"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Inquiry Details</h3>
                        <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <dl class="divide-y divide-gray-100" v-if="detailItem">
                        <div v-for="(value, key) in detailFields" :key="key" class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ key }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2 break-words">{{ value || '—' }}</dd>
                        </div>
                    </dl>
                    <div class="mt-6 flex justify-end">
                        <button @click="showDetailModal = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="showDeleteModal = false"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Entry</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this entry? This action cannot be undone.</p>
                <div class="flex items-center justify-end gap-3">
                    <button @click="showDeleteModal = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button @click="deleteItem"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

interface ServiceInquiry {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    contact: string;
    unit_type: string;
    message: string | null;
    agree_to_privacy: boolean;
    created_at: string;
}

interface PrivateInquiry {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    contact: string;
    unit_type: string;
    message: string | null;
    agree_to_privacy: boolean;
    created_at: string;
}

interface ContactSubmission {
    id: number;
    inquiry_type: string;
    first_name: string;
    last_name: string;
    email: string;
    country_code: string;
    mobile: string;
    project: string;
    description: string;
    agree_terms: boolean;
    created_at: string;
}

interface BookingRequest {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    contact_number: string;
    date: string;
    time: string;
    created_at: string;
}

const props = defineProps<{
    serviceInquiries: ServiceInquiry[];
    privateInquiries: PrivateInquiry[];
    contactSubmissions: ContactSubmission[];
    bookingRequests: BookingRequest[];
    activeTab: string;
}>();

const activeTabKey = ref(props.activeTab || 'service');
const showDetailModal = ref(false);
const showDeleteModal = ref(false);
const detailItem = ref<any>(null);
const detailType = ref('');
const deleteId = ref<number | null>(null);
const deleteType = ref('');

const tabs = computed(() => [
    { key: 'service', label: 'Service Residence', count: props.serviceInquiries.length },
    { key: 'private', label: 'Private Residence', count: props.privateInquiries.length },
    { key: 'contacts', label: 'Contact Us', count: props.contactSubmissions.length },
    { key: 'bookings', label: 'Partners / Brokers', count: props.bookingRequests.length },
]);

const detailFields = computed(() => {
    if (!detailItem.value) return {};
    const item = detailItem.value;
    const type = detailType.value;

    if (type === 'service' || type === 'private') {
        return {
            'Name': `${item.first_name} ${item.last_name}`,
            'Email': item.email,
            'Contact': item.contact,
            'Unit Type': item.unit_type,
            'Message': item.message,
            'Privacy Agreed': item.agree_to_privacy ? 'Yes' : 'No',
            'Submitted': formatDate(item.created_at),
        };
    }
    if (type === 'contacts') {
        return {
            'Name': `${item.first_name} ${item.last_name}`,
            'Inquiry Type': item.inquiry_type,
            'Email': item.email,
            'Mobile': `${item.country_code} ${item.mobile}`,
            'Project': item.project,
            'Description': item.description,
            'Terms Agreed': item.agree_terms ? 'Yes' : 'No',
            'Submitted': formatDate(item.created_at),
        };
    }
    if (type === 'bookings') {
        return {
            'Name': `${item.first_name} ${item.last_name}`,
            'Email': item.email,
            'Contact Number': item.contact_number,
            'Preferred Date': formatDate(item.date),
            'Preferred Time': item.time,
            'Submitted': formatDate(item.created_at),
        };
    }
    return {};
});

function formatDate(dateStr: string): string {
    if (!dateStr) return '—';
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

function viewDetail(item: any, type: string) {
    detailItem.value = item;
    detailType.value = type;
    showDetailModal.value = true;
}

function confirmDelete(id: number, type: string) {
    deleteId.value = id;
    deleteType.value = type;
    showDeleteModal.value = true;
}

function deleteItem() {
    if (!deleteId.value || !deleteType.value) return;

    const routeMap: Record<string, string> = {
        service: 'admin.inquiries.destroy-service',
        private: 'admin.inquiries.destroy-private',
        contacts: 'admin.inquiries.destroy-contact',
        bookings: 'admin.inquiries.destroy-booking',
    };

    const paramMap: Record<string, string> = {
        service: 'inquiry',
        private: 'inquiry1',
        contacts: 'contact',
        bookings: 'booking',
    };

    router.delete(route(routeMap[deleteType.value], { [paramMap[deleteType.value]]: deleteId.value }), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            deleteId.value = null;
            deleteType.value = '';
        },
    });
}
</script>
