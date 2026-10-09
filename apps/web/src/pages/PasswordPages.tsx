import { useMutation } from '@tanstack/react-query'
import { useState } from 'react'
import type { FormEvent } from 'react'
import { Link, useSearchParams } from 'react-router-dom'
import { ApiError, authApi } from '@/api/client'
import { AuthLayout } from '@/components/AuthLayout'
import { Feedback, Field, SubmitButton } from '@/components/FormFields'

export function ForgotPasswordPage() {
  const [email, setEmail] = useState('')
  const request = useMutation({ mutationFn: authApi.forgotPassword })
  const submit = (event: FormEvent) => { event.preventDefault(); request.mutate(email) }
  return <AuthLayout title="Recupere seu acesso" description="Enviaremos as instruções caso exista uma conta para o e-mail informado."><form className="space-y-5" onSubmit={submit}>{request.data && <Feedback tone="success">{request.data.message}</Feedback>}{request.error && <Feedback>Não foi possível concluir a solicitação.</Feedback>}<Field label="E-mail" type="email" required value={email} onChange={(e) => setEmail(e.target.value)} /><SubmitButton pending={request.isPending}>Enviar instruções</SubmitButton><Link className="block text-center text-sm font-medium text-orange-700" to="/login">Voltar para o login</Link></form></AuthLayout>
}

export function ResetPasswordPage() {
  const [params] = useSearchParams(); const [password, setPassword] = useState(''); const [confirmation, setConfirmation] = useState('')
  const reset = useMutation({ mutationFn: authApi.resetPassword })
  const submit = (event: FormEvent) => { event.preventDefault(); reset.mutate({ token: params.get('token') ?? '', email: params.get('email') ?? '', password, password_confirmation: confirmation }) }
  const error = reset.error instanceof ApiError ? reset.error.errors?.email?.[0] ?? reset.error.message : undefined
  return <AuthLayout title="Defina uma nova senha" description="O link é temporário e deixa de funcionar depois da redefinição."><form className="space-y-5" onSubmit={submit}>{reset.data && <Feedback tone="success">{reset.data.message} <Link className="font-semibold underline" to="/login">Entrar</Link></Feedback>}{error && <Feedback>{error}</Feedback>}<Field label="Nova senha" type="password" minLength={10} required value={password} onChange={(e) => setPassword(e.target.value)} /><Field label="Confirme a nova senha" type="password" minLength={10} required value={confirmation} onChange={(e) => setConfirmation(e.target.value)} /><SubmitButton pending={reset.isPending}>Redefinir senha</SubmitButton></form></AuthLayout>
}
