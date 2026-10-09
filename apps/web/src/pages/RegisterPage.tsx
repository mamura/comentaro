import { useMutation, useQueryClient } from '@tanstack/react-query'
import { useState } from 'react'
import type { FormEvent } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { ApiError, authApi } from '@/api/client'
import { AuthLayout } from '@/components/AuthLayout'
import { Feedback, Field, SubmitButton } from '@/components/FormFields'

export function RegisterPage() {
  const [form, setForm] = useState({ name: '', organization_name: '', email: '', password: '', password_confirmation: '' })
  const navigate = useNavigate(); const queryClient = useQueryClient()
  const register = useMutation({ mutationFn: authApi.register, onSuccess: async (data) => { queryClient.setQueryData(['auth-user'], data); await navigate('/') } })
  const update = (key: keyof typeof form) => (event: React.ChangeEvent<HTMLInputElement>) => setForm({ ...form, [key]: event.target.value })
  const submit = (event: FormEvent) => { event.preventDefault(); register.mutate(form) }
  const errors = register.error instanceof ApiError ? register.error.errors : undefined

  return <AuthLayout title="Crie sua conta" description="Cadastre o responsável e a organização que será acompanhada.">
    <form className="space-y-5" onSubmit={submit}>
      {register.error && <Feedback>{register.error instanceof ApiError ? register.error.message : 'Não foi possível criar a conta.'}</Feedback>}
      <Field label="Seu nome" autoComplete="name" required value={form.name} onChange={update('name')} error={errors?.name?.[0]} />
      <Field label="Nome da organização" autoComplete="organization" required value={form.organization_name} onChange={update('organization_name')} error={errors?.organization_name?.[0]} />
      <Field label="E-mail" type="email" autoComplete="email" required value={form.email} onChange={update('email')} error={errors?.email?.[0]} />
      <Field label="Senha" type="password" minLength={10} autoComplete="new-password" required value={form.password} onChange={update('password')} error={errors?.password?.[0]} />
      <Field label="Confirme a senha" type="password" minLength={10} autoComplete="new-password" required value={form.password_confirmation} onChange={update('password_confirmation')} />
      <p className="text-xs leading-5 text-slate-500">Use pelo menos 10 caracteres.</p>
      <SubmitButton pending={register.isPending}>Criar conta</SubmitButton>
      <p className="text-center text-sm text-slate-600">Já possui conta? <Link className="font-semibold text-orange-700 hover:underline" to="/login">Entrar</Link></p>
    </form>
  </AuthLayout>
}
