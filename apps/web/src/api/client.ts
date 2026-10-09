import type { components } from './schema'

const apiUrl = import.meta.env.VITE_API_URL ?? 'http://localhost:8000/api/v1'
export type Health = components['schemas']['Health']

export async function getHealth(): Promise<Health> {
  const response = await fetch(`${apiUrl}/health`, {
    credentials: 'include',
    headers: { Accept: 'application/json' },
  })

  if (!response.ok) {
    throw new Error('A API não respondeu como esperado.')
  }

  return response.json() as Promise<Health>
}
