import Cookies from 'js-cookie'

const TokenType = 'token_type'
const expiresIn = 'expires_in'
const refreshToken = 'refresh_token'
const TokenKey = 'access_token'

export function getToken() {
  return Cookies.get(TokenKey)
}

export function getPassport() {
  const passport = {}
  passport.tokenType = Cookies.get(TokenType)
  passport.expiresIn = Cookies.get(expiresIn)
  passport.refreshToken = Cookies.get(refreshToken)
  passport.accessToken = Cookies.get(TokenKey)
  return passport
}

export function setToken(token) {
  Cookies.set(TokenType, token.token_type)
  Cookies.set(refreshToken, token.refresh_token)
  Cookies.set(expiresIn, token.expires_in)
  return Cookies.set(TokenKey, token.access_token)
}

export function removeToken() {
  Cookies.remove(TokenType)
  Cookies.remove(refreshToken)
  Cookies.remove(expiresIn)
  return Cookies.remove(TokenKey)
}
