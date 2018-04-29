# @see

https://docs.gitlab.com/omnibus/docker/

## How to reset root's passwork?

```
sudo -u git -H bundle exec rails console production
```

```
user = User.where(id: 1).first
```

```
user.password = 'secret_pass'

user.password_confirmation = 'secret_pass'
```

```
user.save!
```
