<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    }
});

const form = useForm({
  title: props.post.title,
  content: props.post.content,
  image: null,
});


const handleFileChange = (e) => {
    form.image = e.target.files[0];
}

const submit = ()=>{
  form.put(`/posts/${props.post.id}`,{
  forceFormData: true,
  })
};

</script>

<template>
    <Head title="投稿編集" />
    <div>
        <h1>投稿編集</h1>
        <form @submit.prevent="submit">
            <div>
                <label for="title">タイトル</label>
                <input v-model="form.title" id="title" type="text" />
                <div v-if="form.errors.title" class="text-red-600">{{ form.errors.title }}</div>
            </div>
            <div>
                <label for="content">レシピ詳細</label>
                <textarea v-model="form.content" id="content"></textarea>
                <div v-if="form.errors.content" class="text-red-600">{{ form.errors.content }}</div>
            </div>
            <div>
                <label for="image">画像アップロード</label>
                <div v-if="form.existingImagePath">
                    <img :src="form.existingImagePath" alt="Current Image" style="max-width: 200px;" />
                </div>
                <input @change="handleFileChange" type="file" id="image" />
            </div>
            <button type="submit">送信</button>
        </form>
    </div>
</template>
