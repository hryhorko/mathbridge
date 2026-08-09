import jwt

from jupyterhub.auth import Authenticator
from jupyterhub.handlers import LoginHandler
from tornado import web


SECRET = "Edit me"


class JWTAuthenticator(Authenticator):

    auto_login = True

    async def authenticate(self, handler, data=None):
        token = handler.get_argument("token", None)

        if not token:
            return None

        try:
            payload = jwt.decode(
                token,
                SECRET,
                algorithms=["HS256"]
            )
        except Exception:
            raise web.HTTPError(403, "Invalid token")

        username = payload.get("username")

        if not username:
            raise web.HTTPError(403, "Invalid payload")

        self.log.info(
            "JWT authentication successful: %s",
            username
        )

        return username

    def get_handlers(self, app):
        return [
            ("/login", JWTLoginHandler)
        ]


class JWTLoginHandler(LoginHandler):

    async def get(self):

        token = self.get_argument(
            "token",
            default=None
        )

        if token:

            self.log.info(
                "JWT SSO login request received"
            )

            user = await self.login_user(
                {
                    "token": token
                }
            )

            if user:

                self.log.info(
                    "JWT SSO session switched to: %s",
                    user.name
                )

                self.redirect(
                    self.get_next_url(user)
                )

                return

            raise web.HTTPError(
                403,
                "JWT authentication failed"
            )

        # No JWT:
        # preserve the normal JupyterHub login behaviour.
        await super().get()


c.JupyterHub.authenticator_class = JWTAuthenticator

c.Authenticator.allow_all = True