<template>
    <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
        <h1 class="font-normal mb-16 text-center text-2xl ">Let's Start Something New</h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <label for="title" class="text-sm block mb-2">Title</label>
                        <input
                            type="text"
                            id="title"
                            class="border border-muted-light p-2 px-2 text-xs block w-full rounded"
                            :class="form.errors.title ? 'border-error' : 'border-muted-light'"
                            v-model="form.title"
                        />
                        <span class="text-xs italic text-error" v-if="form.errors.title" v-text="form.errors.title[0]"></span>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="text-sm block mb-2">Description</label>
                        <textarea
                            type="text"
                            id="description"
                            class="border border-muted-light p-2 px-2 text-xs block w-full rounded"
                            :class="form.errors.description ? 'border-error' : 'border-muted-light'"
                            rows="7"
                            v-model="form.description"></textarea>
                        <span class="text-xs italic text-error" v-if="form.errors.description" v-text="form.errors.description[0]"></span>
                    </div>
                </div>
                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <label class="text-sm block mb-2">Need Some Tasks?</label>
                        <input
                            type="text"
                            class="border border-muted-light mb-2 p-2 px-2 text-xs block w-full rounded"
                            placeholder="Task 1"
                            v-for="task in form.tasks"
                            v-model="task.body"
                        />
                    </div>
                    <button type="button" class="inline-flex items-center text-xs mb-4" @click="addTask">
                        <span class="mr-2">+</span>
                        <span>Add new task field</span>
                    </button>
                </div>
            </div>

            <footer class="flex justify-end">
                <button type="button" class="button is-outlined mr-4" @click="$modal.hide('new-project')">Cancel</button>
                <button type="submit" class="button">Create Project</button>
            </footer>
        </form>
    </modal>
</template>

<script>
    import MainForm from "./MainForm";
    export default {
        data() {
            return {
                form: new MainForm({
                    title: '',
                    description: '',
                    tasks: [
                        { body: '' },
                    ]
                }),
            }
        },

        methods: {
            addTask() {
                this.form.tasks.push({ body: '' })
            },

            async submit() {
                if(! this.form.tasks[0].body) {
                    delete this.form.originalData.tasks;
                }

                this.form.submit('/projects')
                    .then(response => location = response.data.message)
            }
        }
    }
</script>

<style scoped>

</style>
