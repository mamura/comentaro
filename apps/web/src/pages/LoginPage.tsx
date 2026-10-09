import { useMutation, useQueryClient } from '@tanstack/react-query'
import { useState } from 'react'
import type { FormEvent } from 'react'
import { Link, useNavigate, useSearchParams } from 'react-router-dom'
import { ApiError, authApi } from '@/api/client'
import { AuthLayout } from '@/components/AuthLayout'
import { Feedback, Field, SubmitButton } from '@/components/FormFields'

export function LoginPage() {
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [remember, setRemember] = useState(false)
  const [params] = useSearchParams()
  const navigate = useNavigate()
  const queryClient = useQueryClient()
  const login = useMutation({ mutationFn: authApi.login, onSuccess: async (data) => { queryClient.setQueryData(['auth-user'], data); await navigate('/') } })

  function submit(event: FormEvent) {
    event.preventDefault()
    login.mutate({ email, password, remember })
  }

  return <AuthLayout title="Entre na sua conta" description="Acompanhe as avaliações dos estabelecimentos da sua organização.">
    <form className="space-y-5" onSubmit={submit}>
      {params.get('email_verified') && <Feedback tone="success">E-mail confirmado. Sua conta está pronta para uso.</Feedback>}
      {login.error && <Feedback>{login.error instanceof ApiError ? login.error.errors?.email?.[0] ?? login.error.message : 'Não foi possível entrar.'}</Feedback>}
      <Field label="E-mail" type="email" autoComplete="email" required value={email} onChange={(e) => setEmail(e.target.value)} />
      <Field label="Senha" type="password" autoComplete="current-password" required value={password} onChange={(e) => setPassword(e.target.value)} />
      <div className="flex items-center justify-between gap-4 text-sm"><label className="flex items-center gap-2 text-slate-600"><input type="checkbox" checked={remember} onChange={(e) => setRemember(e.target.checked)} /> Manter conectado</label><Link className="font-medium text-orange-700 hover:underline" to="/forgot-password">Esqueci minha senha</Link></div>
      <SubmitButton pending={login.isPending}>Entrar</SubmitButton>
      <p className="text-center text-sm text-slate-600">Ainda não tem conta? <Link className="font-semibold text-orange-700 hover:underline" to="/register">Criar conta</Link></p>
    </form>
  </AuthLayout>
}
