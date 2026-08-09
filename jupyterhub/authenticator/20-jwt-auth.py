import jwt
from jupyterhub.auth import Authenticator
from tornado import web

SECRET = "MY_SUPER_SECRET_KEY"

class JWTAuthenticator(Authenticator):

    auto_login = True

    async def authenticate(self, handler, data=None):
        token = handler.get_argument("token", None)

        if not token:
            return None

        try:
            payload = jwt.decode(token, SECRET, algorithms=["HS256"])
        except Exception:
            raise web.HTTPError(403, "Invalid token")

        username = payload.get("username")

        if not username:
            raise web.HTTPError(403, "Invalid payload")

        return username

c.JupyterHub.authenticator_class = JWTAuthenticator

c.Authenticator.allow_all = True
