SimpleHttpAuth
==============

1) Register extension in `config.neon`:

```
  extensions:
    simpleHttpAuth: Ublaboo\SimpleHttpAuth\DI\SimpleHttpAuthExtension
```

2) Tell which presenters shoul be secured (in case no presenter name given, all presenters are secured). Format - `Module:Module:Presenter`:

```
  simpleHttpAuth:
    username: admin
    password: rbxpmYsPB6RSlqMIUV8i
    presenters: [Front:Admin] # Secure presenter class App\FrontModule\Presenters\AdminPresenter
```
