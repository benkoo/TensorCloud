## Zero to deploy k8s JupyterHub on AWS

Demo: http://a1b3b29023d4a11e8bfb902e2ccdec50-467817900.us-west-2.elb.amazonaws.com test/test

Ref:https://zero-to-jupyterhub.readthedocs.io/en/latest/

Steps:
```
helm install --debug --dry-run jupyterhub/jupyterhub \
    --version=v0.4 \
    --name=jhub \
    --namespace=jhub \
    -f config.yaml

    export KUBECONFIG=$(pwd)/kubeconfig
```
hub:
```
  # output of first execution of 'openssl rand -hex 32'
  cookieSecret: "9d5ffa719eae597d263395b7258254ef12334ff4fafd7f9b290cd7a041767176"
```
proxy:
```
# output of second execution of 'openssl rand -hex 32'
secretToken: "e12d13284d4343fd70741412968676420d499e2122a407de31fd591906807a2e"
```
```
helm install jupyterhub/jupyterhub \
    --version=v0.6 \
    --name=jhub \
    --namespace=jhub \
    -f config.yaml
```
```
kubectl --namespace=jhub get pod
```
```
kubectl --namespace=jhub describe svc proxy-public
```

# References

https://github.com/jupyter/docker-stacks

https://github.com/jupyterhub/jupyterhub

https://github.com/jupyterhub/jupyterhub-deploy-docker

https://github.com/jupyterhub/zero-to-jupyterhub-k8s
