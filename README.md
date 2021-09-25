# UnknownCommandMessage

**UnknownCommandMessage is a plugin made on API 4.0.0 for MCPE.**
> This was tested on API 4.0.0-BETA3 and MCPE 1.17.30! Note, warranty is not promised. 

## What does this do?
> When a player runs a command, it should send them this typical message:
> https://cdn.discordapp.com/attachments/375005361154949120/891306297776042034/unknown.png

## Usage
> It's actually pretty simple. All you need is to pull up the ``config.yml`` file like so, it should look something like this:
```yaml
messages:
# Use {cmd_name} for Command Name, use {player} for Player Name.
  unknown-command: "&cThe command {cmd_name} does not exist."
```

## Editing the message
> You can set the messages to anything you want. Yes, we do use the ``&`` symbol instead of the section sign (§) 
