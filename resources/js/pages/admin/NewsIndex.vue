<template>
    <AdminLayout title="News Maintenance">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">News Slides</h3>
                <p class="text-sm text-gray-500">Manage the image carousel shown on the homepage.</p>
            </div>
            <button @click="openCreateModal"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Slide
            </button>
        </div>

        <!-- Empty state -->
        <div v-if="news.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-sm font-medium text-gray-900 mb-1">No slides yet</h3>
            <p class="text-sm text-gray-500 mb-4">Add your first news slide to get started.</p>
            <button @click="openCreateModal"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">
                Add Slide
            </button>
        </div>

        <!-- Slides grid -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="item in news" :key="item.id"
                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden group">
                <!-- Image preview -->
                <div class="relative aspect-video bg-gray-100">
                    <img :src="item.image_url" :alt="item.alt_text || 'Slide '"
                        class="w-full h-full object-cover" />
                    <div class="absolute top-2 right-2 flex gap-1">
                        <span v-if="item.is_active"
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                        <span v-else
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            Inactive
                        </span>
                    </div>
                </div>
                <!-- Card content -->
                <div class="p-4">
                    <h4 class="font-medium text-gray-900 text-sm truncate">
                        {{ item.title || '(No title)' }}
                    </h4>
                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                        {{ item.description || '(No description)' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-2">Sort order: {{ item.sort_order }}</p>
                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                        <button @click="openEditModal(item)"
                            class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                        <button @click="confirmDelete(item)"
                            class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create / Edit Modal -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeModal"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ editingItem ? 'Edit Slide' : 'Add New Slide' }}
                        </h3>
                        <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <!-- Image upload -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Image *</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gray-400 transition-colors cursor-pointer"
                                @click="($refs.fileInput as HTMLInputElement).click()"
                                @dragover.prevent
                                @drop.prevent="handleDrop">
                                <div v-if="imagePreview" class="mb-2">
                                    <img :src="imagePreview" class="max-h-48 mx-auto rounded-lg object-cover" />
                                </div>
                                <div v-else>
                                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500">Click or drag & drop to upload</p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP up to 20MB (auto-optimized)</p>
                            </div>
                            <input ref="fileInput" type="file" accept="image/jpeg,image/png,image/webp" class="hidden" @change="handleFileSelect" />
                            <p v-if="form.errors.image" class="text-sm text-red-600 mt-1">{{ form.errors.image }}</p>
                        </div>

                        <!-- Title -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input v-model="form.title" type="text" placeholder="Optional slide title"
                                class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none" />
                            <p v-if="form.errors.title" class="text-sm text-red-600 mt-1">{{ form.errors.title }}</p>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea v-model="form.description" rows="2" placeholder="Optional slide description"
                                class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none resize-none"></textarea>
                            <p v-if="form.errors.description" class="text-sm text-red-600 mt-1">{{ form.errors.description }}</p>
                        </div>

                        <!-- Alt text -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alt text</label>
                            <input v-model="form.alt_text" type="text" placeholder="Image alt text for accessibility"
                                class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none" />
                        </div>

                        <!-- Sort order & Active -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                                <input v-model.number="form.sort_order" type="number" min="0"
                                    class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none" />
                            </div>
                            <div class="flex items-end">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input v-model="form.is_active" type="checkbox"
                                        class="w-4 h-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900" />
                                    <span class="text-sm font-medium text-gray-700">Active</span>
                                </label>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-3">
                            <button type="button" @click="closeModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" :disabled="form.processing"
                                class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors disabled:opacity-50">
                                {{ form.processing ? 'Saving...' : (editingItem ? 'Update' : 'Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete confirmation -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="showDeleteModal = false"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Slide</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this slide? This action cannot be undone.</p>
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
import { useForm, router } from '@inertiajs/vue3';
import axios from 'axios';
import AdminLayout from '@/layouts/AdminLayout.vue';

interface NewsItem {
    id: number;
    title: string | null;
    description: string | null;
    image_path: string;
    image_url: string;
    alt_text: string | null;
    sort_order: number;
    is_active: boolean;
}

const props = defineProps<{
    news: NewsItem[];
}>();

const showModal = ref(false);
const showDeleteModal = ref(false);
const editingItem = ref<NewsItem | null>(null);
const deletingItem = ref<NewsItem | null>(null);
const imagePreview = ref<string | null>(null);
const selectedFile = ref<File | null>(null);

const form = useForm({
    title: '' as string,
    description: '' as string,
    image: null as File | null,
    alt_text: '' as string,
    sort_order: 0,
    is_active: true,
});

function openCreateModal() {
    editingItem.value = null;
    imagePreview.value = null;
    selectedFile.value = null;
    form.reset();
    form.clearErrors();
    form.is_active = true;
    form.sort_order = props.news.length;
    showModal.value = true;
}

function openEditModal(item: NewsItem) {
    editingItem.value = item;
    imagePreview.value = item.image_url;
    selectedFile.value = null;
    form.title = item.title || '';
    form.description = item.description || '';
    form.alt_text = item.alt_text || '';
    form.sort_order = item.sort_order;
    form.is_active = item.is_active as any;
    form.image = null;
    form.clearErrors();
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
    editingItem.value = null;
    imagePreview.value = null;
    selectedFile.value = null;
    form.reset();
}

function handleFileSelect(e: Event) {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        selectedFile.value = target.files[0];
        form.image = target.files[0];
        imagePreview.value = URL.createObjectURL(target.files[0]);
    }
}

function handleDrop(e: DragEvent) {
    if (e.dataTransfer?.files && e.dataTransfer.files[0]) {
        selectedFile.value = e.dataTransfer.files[0];
        form.image = e.dataTransfer.files[0];
        imagePreview.value = URL.createObjectURL(e.dataTransfer.files[0]);
    }
}

function submitForm() {
    // Build FormData manually and use axios directly
    // (Inertia's useForm reactive proxy breaks File instanceof checks)
    const data = new FormData();
    data.append('title', form.title || '');
    data.append('description', form.description || '');
    data.append('alt_text', form.alt_text || '');
    data.append('sort_order', String(form.sort_order));
    data.append('is_active', form.is_active ? '1' : '0');

    // Use the raw File from the ref, not the reactive proxy
    if (selectedFile.value) {
        data.append('image', selectedFile.value);
    }

    const url = editingItem.value
        ? route('admin.news.update', { news: editingItem.value.id })
        : route('admin.news.store');

    form.processing = true;
    form.clearErrors();

    axios.post(url, data, {
        headers: {
            'Content-Type': 'multipart/form-data',
            'X-Requested-With': 'XMLHttpRequest',
        },
    }).then(() => {
        form.processing = false;
        closeModal();
        // Refresh the page via Inertia to get updated data
        router.reload();
    }).catch((error) => {
        form.processing = false;
        if (error.response?.status === 422 && error.response?.data?.errors) {
            const errors = error.response.data.errors;
            Object.keys(errors).forEach((key) => {
                (form.errors as any)[key] = errors[key][0];
            });
        } else {
            alert('Upload failed: ' + (error.response?.data?.message || error.message));
        }
    });
}

function confirmDelete(item: NewsItem) {
    deletingItem.value = item;
    showDeleteModal.value = true;
}

function deleteItem() {
    if (deletingItem.value) {
        router.delete(route('admin.news.destroy', { news: deletingItem.value.id }), {
            preserveScroll: true,
            onSuccess: () => {
                showDeleteModal.value = false;
                deletingItem.value = null;
            },
        });
    }
}
</script>
