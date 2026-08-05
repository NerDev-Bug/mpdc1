<template>
    <AdminLayout title="News Maintenance">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">News Slides and Articles</h3>
                <p class="text-sm text-gray-500">Manage homepage slides and optionally publish complete, crawlable articles.</p>
            </div>
            <button
                @click="openCreateModal"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add News Item
            </button>
        </div>

        <!-- Empty state -->
        <div v-if="news.length === 0" class="rounded-xl border border-gray-200 bg-white p-12 text-center shadow-sm">
            <svg class="mx-auto mb-4 h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                />
            </svg>
            <h3 class="mb-1 text-sm font-medium text-gray-900">No news items yet</h3>
            <p class="mb-4 text-sm text-gray-500">Add your first homepage slide or article to get started.</p>
            <button
                @click="openCreateModal"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800"
            >
                Add News Item
            </button>
        </div>

        <!-- Slides grid -->
        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div v-for="item in news" :key="item.id" class="group overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <!-- Image preview -->
                <div class="relative aspect-video bg-gray-100">
                    <img :src="item.image_url" :alt="item.alt_text || 'Slide '" class="h-full w-full object-cover" />
                    <div class="absolute right-2 top-2 flex gap-1">
                        <span
                            v-if="item.is_active"
                            class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800"
                        >
                            Active
                        </span>
                        <span v-else class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">
                            Inactive
                        </span>
                        <span
                            class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium"
                            :class="articleStatusClass(item.article_status)"
                        >
                            {{ articleStatusLabel(item.article_status) }}
                        </span>
                    </div>
                </div>
                <!-- Card content -->
                <div class="p-4">
                    <h4 class="truncate text-sm font-medium text-gray-900">
                        {{ item.title || '(No title)' }}
                    </h4>
                    <p class="mt-1 line-clamp-2 text-xs text-gray-500">
                        {{ item.description || '(No description)' }}
                    </p>
                    <p class="mt-2 text-xs text-gray-400">Sort order: {{ item.sort_order }}</p>
                    <a
                        v-if="item.article_url"
                        :href="item.article_url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-2 inline-flex text-xs font-medium text-blue-700 hover:underline"
                    >
                        View published article
                    </a>
                    <div class="mt-3 flex items-center gap-2 border-t border-gray-100 pt-3">
                        <button
                            @click="openEditModal(item)"
                            class="inline-flex flex-1 items-center justify-center gap-1 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 transition-colors hover:bg-gray-200"
                        >
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                />
                            </svg>
                            Edit
                        </button>
                        <button
                            @click="confirmDelete(item)"
                            class="inline-flex flex-1 items-center justify-center gap-1 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 transition-colors hover:bg-red-100"
                        >
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                />
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
            <div class="relative mx-4 max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-xl bg-white shadow-xl">
                <div class="p-6">
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ editingItem ? 'Edit News Item' : 'Add News Item' }}
                        </h3>
                        <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <!-- Image upload -->
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Image {{ editingItem ? '' : '*' }}</label>
                            <div
                                class="cursor-pointer rounded-lg border-2 border-dashed border-gray-300 p-4 text-center transition-colors hover:border-gray-400"
                                @click="($refs.fileInput as HTMLInputElement).click()"
                                @dragover.prevent
                                @drop.prevent="handleDrop"
                            >
                                <div v-if="imagePreview" class="mb-2">
                                    <img :src="imagePreview" :alt="form.alt_text || ''" class="mx-auto max-h-48 rounded-lg object-cover" />
                                </div>
                                <div v-else>
                                    <svg class="mx-auto mb-2 h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                        />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500">Click or drag & drop to upload</p>
                                <p class="mt-1 text-xs text-gray-400">JPG, PNG, WebP up to 20MB (auto-optimized)</p>
                            </div>
                            <input ref="fileInput" type="file" accept="image/jpeg,image/png,image/webp" class="hidden" @change="handleFileSelect" />
                            <p v-if="form.errors.image" class="mt-1 text-sm text-red-600">{{ form.errors.image }}</p>
                        </div>

                        <!-- Title -->
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Title</label>
                            <input
                                v-model="form.title"
                                type="text"
                                maxlength="191"
                                placeholder="Slide or article title"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 outline-none focus:border-transparent focus:ring-2 focus:ring-gray-900"
                            />
                            <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Summary</label>
                            <textarea
                                v-model="form.description"
                                rows="2"
                                placeholder="Optional short summary for the slide and article listing"
                                class="w-full resize-none rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 outline-none focus:border-transparent focus:ring-2 focus:ring-gray-900"
                            ></textarea>
                            <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
                        </div>

                        <!-- Alt text -->
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Alt text</label>
                            <input
                                v-model="form.alt_text"
                                type="text"
                                maxlength="191"
                                placeholder="Image alt text for accessibility"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 outline-none focus:border-transparent focus:ring-2 focus:ring-gray-900"
                            />
                            <p v-if="form.errors.alt_text" class="mt-1 text-sm text-red-600">{{ form.errors.alt_text }}</p>
                        </div>

                        <fieldset class="mb-5 rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <legend class="px-1 text-sm font-semibold text-gray-900">Optional public article</legend>
                            <p class="mb-4 text-xs leading-5 text-gray-500">
                                Leave the publication date empty for a carousel-only item or draft. Setting a publication date requires a title, URL
                                slug, article body, and image alt text. Future dates are scheduled automatically.
                            </p>

                            <div class="mb-4">
                                <label class="mb-1 block text-sm font-medium text-gray-700">URL slug</label>
                                <input
                                    v-model="form.slug"
                                    type="text"
                                    maxlength="191"
                                    placeholder="example-article-title"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 outline-none focus:border-transparent focus:ring-2 focus:ring-gray-900"
                                />
                                <p class="mt-1 text-xs text-gray-500">Use a short, unique phrase. Spaces are converted to hyphens when saved.</p>
                                <p v-if="form.errors.slug" class="mt-1 text-sm text-red-600">{{ form.errors.slug }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="mb-1 block text-sm font-medium text-gray-700">Article body</label>
                                <textarea
                                    v-model="form.body"
                                    rows="8"
                                    placeholder="Write the complete article in plain text. Separate paragraphs with a blank line."
                                    class="w-full resize-y rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 outline-none focus:border-transparent focus:ring-2 focus:ring-gray-900"
                                ></textarea>
                                <p v-if="form.errors.body" class="mt-1 text-sm text-red-600">{{ form.errors.body }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="mb-1 block text-sm font-medium text-gray-700">Publication date and time (Philippine time)</label>
                                <input
                                    v-model="form.published_at"
                                    type="datetime-local"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 outline-none focus:border-transparent focus:ring-2 focus:ring-gray-900"
                                />
                                <p v-if="form.errors.published_at" class="mt-1 text-sm text-red-600">{{ form.errors.published_at }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="mb-1 block text-sm font-medium text-gray-700">SEO title</label>
                                <input
                                    v-model="form.meta_title"
                                    type="text"
                                    maxlength="60"
                                    placeholder="Optional; article title is used by default and MPDC is added automatically"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 outline-none focus:border-transparent focus:ring-2 focus:ring-gray-900"
                                />
                                <p v-if="form.errors.meta_title" class="mt-1 text-sm text-red-600">{{ form.errors.meta_title }}</p>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">SEO description</label>
                                <textarea
                                    v-model="form.meta_description"
                                    rows="2"
                                    maxlength="160"
                                    placeholder="Optional; the summary or article body is used by default"
                                    class="w-full resize-none rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 outline-none focus:border-transparent focus:ring-2 focus:ring-gray-900"
                                ></textarea>
                                <p v-if="form.errors.meta_description" class="mt-1 text-sm text-red-600">{{ form.errors.meta_description }}</p>
                            </div>
                        </fieldset>

                        <!-- Sort order & Active -->
                        <div class="mb-6 grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Sort Order</label>
                                <input
                                    v-model.number="form.sort_order"
                                    type="number"
                                    min="0"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 outline-none focus:border-transparent focus:ring-2 focus:ring-gray-900"
                                />
                            </div>
                            <div class="flex items-end">
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input
                                        v-model="form.is_active"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                                    />
                                    <span class="text-sm font-medium text-gray-700">Active</span>
                                </label>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-3">
                            <button
                                type="button"
                                @click="closeModal"
                                class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800 disabled:opacity-50"
                            >
                                {{ form.processing ? 'Saving...' : editingItem ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete confirmation -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="showDeleteModal = false"></div>
            <div class="relative mx-4 w-full max-w-sm rounded-xl bg-white p-6 shadow-xl">
                <h3 class="mb-2 text-lg font-semibold text-gray-900">Delete Slide</h3>
                <p class="mb-6 text-sm text-gray-500">Are you sure you want to delete this slide? This action cannot be undone.</p>
                <div class="flex items-center justify-end gap-3">
                    <button
                        @click="showDeleteModal = false"
                        class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200"
                    >
                        Cancel
                    </button>
                    <button
                        @click="deleteItem"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { router, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

interface NewsItem {
    id: number;
    title: string | null;
    slug: string | null;
    description: string | null;
    body: string | null;
    image_path: string;
    image_url: string;
    alt_text: string | null;
    sort_order: number;
    is_active: boolean;
    published_at: string | null;
    meta_title: string | null;
    meta_description: string | null;
    article_status: 'published' | 'scheduled' | 'inactive' | 'draft' | 'carousel_only';
    article_url: string | null;
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
    slug: '' as string,
    description: '' as string,
    body: '' as string,
    image: null as File | null,
    alt_text: '' as string,
    sort_order: 0,
    is_active: true as boolean,
    published_at: '' as string,
    meta_title: '' as string,
    meta_description: '' as string,
});

const articleStatusLabel = (status: NewsItem['article_status']) =>
    ({
        published: 'Published article',
        scheduled: 'Scheduled article',
        inactive: 'Inactive article',
        draft: 'Article draft',
        carousel_only: 'Carousel only',
    })[status];

const articleStatusClass = (status: NewsItem['article_status']) =>
    ({
        published: 'bg-blue-100 text-blue-800',
        scheduled: 'bg-amber-100 text-amber-800',
        inactive: 'bg-gray-100 text-gray-600',
        draft: 'bg-purple-100 text-purple-800',
        carousel_only: 'bg-slate-100 text-slate-700',
    })[status];

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
    form.slug = item.slug || '';
    form.description = item.description || '';
    form.body = item.body || '';
    form.alt_text = item.alt_text || '';
    form.sort_order = item.sort_order;
    form.is_active = item.is_active;
    form.published_at = item.published_at || '';
    form.meta_title = item.meta_title || '';
    form.meta_description = item.meta_description || '';
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
    data.append('slug', form.slug || '');
    data.append('description', form.description || '');
    data.append('body', form.body || '');
    data.append('alt_text', form.alt_text || '');
    data.append('sort_order', String(form.sort_order));
    data.append('is_active', form.is_active ? '1' : '0');
    data.append('published_at', form.published_at || '');
    data.append('meta_title', form.meta_title || '');
    data.append('meta_description', form.meta_description || '');

    // Use the raw File from the ref, not the reactive proxy
    if (selectedFile.value) {
        data.append('image', selectedFile.value);
    }

    const url = editingItem.value ? route('admin.news.update', { news: editingItem.value.id }) : route('admin.news.store');

    form.processing = true;
    form.clearErrors();

    axios
        .post(url, data, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(() => {
            form.processing = false;
            closeModal();
            // Refresh the page via Inertia to get updated data
            router.reload();
        })
        .catch((error) => {
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
