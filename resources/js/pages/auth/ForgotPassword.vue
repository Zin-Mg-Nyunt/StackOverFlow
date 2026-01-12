<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import Otp from '@/pages/components/Otp.vue';
import { store } from '@/routes/login';
import { email } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';

defineOptions({
    layout: null,
});

const props = defineProps<{
    status?: string;
    email?: string;
    expire_at?: number;
}>();

// URL က redirect parameter ကို ဖတ်ထားမယ်
const redirectPath = new URLSearchParams(window.location.search).get(
    'redirect',
);
</script>

<template>
    <AuthBase title="Forgot your password?" description="">
        <Head title="Forgot password" />
        <Otp
            v-if="props.email"
            :email="props.email || ''"
            :status="props.status || ''"
            :expire_at="props.expire_at || 0"
        />

        <template v-else>
            <p class="text-center text-sm text-gray-500">
                Enter your email address and we'll send you a verification code
            </p>
            <Form
                v-bind="email.form()"
                :reset-on-success="['email']"
                v-slot="{ errors, processing }"
                class="flex flex-col gap-6"
            >
                <input
                    v-if="redirectPath"
                    type="hidden"
                    name="redirect"
                    :value="redirectPath"
                />
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="email"
                            placeholder="email@example.com"
                        />
                        <InputError :message="errors.email" />
                    </div>

                    <Button
                        type="submit"
                        class="mt-4 w-full"
                        :tabindex="2"
                        :disabled="processing"
                        data-test="forgot-password-button"
                    >
                        <Spinner v-if="processing" />
                        Send verification code
                    </Button>
                </div>

                <div class="text-center text-sm text-muted-foreground">
                    Remember your password?
                    <TextLink :href="store.url()" :tabindex="3">
                        Log in
                    </TextLink>
                </div>
            </Form>
        </template>
    </AuthBase>
</template>
