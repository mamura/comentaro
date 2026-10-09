import type { components } from '@/api/schema'

export type ApiUser = components['schemas']['User']

const configuredUrl = import.meta.env.VITE_API_URL ?? 'http://localhost:8000/api/v1'
const apiUrl = configuredUrl.replace(/\/$/, '')
const apiOrigin = new URL(apiUrl, window.location.origin).origin

export class ApiError extends Error {
  readonly status: number
  readonly errors?: Record<string, string[]>

  constructor(message: string, status: number, errors?: Record<string, string[]>) {
    super(message)
    this.status = status
    this.errors = errors
  }
}

function xsrfToken() {
  const cookie = document.cookie
    .split('; ')
    .find((item) => item.startsWith('XSRF-TOKEN='))
    ?.split('=')
    .slice(1)
    .join('=')

  return cookie ? decodeURIComponent(cookie) : undefined
}

async function request<T>(path: string, options: RequestInit = {}): Promise<T> {
  const headers = new Headers(options.headers)
  headers.set('Accept', 'application/json')

  if (options.body) headers.set('Content-Type', 'application/json')
  const token = xsrfToken()
  if (token) headers.set('X-XSRF-TOKEN', token)

  const response = await fetch(`${apiUrl}${path}`, {
    ...options,
    credentials: 'include',
    headers,
  })

  if (!response.ok) {
    const body = await response.json().catch(() => ({ message: 'Não foi possível concluir a solicitação.' }))
    throw new ApiError(body.message ?? 'Não foi possível concluir a solicitação.', response.status, body.errors)
  }

  return response.json() as Promise<T>
}

async function csrf() {
  await fetch(`${apiOrigin}/sanctum/csrf-cookie`, { credentials: 'include' })
}

async function mutate<T>(path: string, body?: unknown) {
  await csrf()
  return request<T>(path, {
    method: 'POST',
    body: body === undefined ? undefined : JSON.stringify(body),
  })
}

export const authApi = {
  user: () => request<{ user: ApiUser }>('/auth/user'),
  register: (data: Record<string, unknown>) => mutate<{ user: ApiUser }>('/auth/register', data),
  login: (data: Record<string, unknown>) => mutate<{ user: ApiUser }>('/auth/login', data),
  logout: () => mutate<{ message: string }>('/auth/logout'),
  resendVerification: () => mutate<{ message: string }>('/auth/email/verification-notification'),
  forgotPassword: (email: string) => mutate<{ message: string }>('/auth/forgot-password', { email }),
  resetPassword: (data: Record<string, unknown>) => mutate<{ message: string }>('/auth/reset-password', data),
}
