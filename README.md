# AutoSubtitles
Automatically download subtitles for a given video file, from multiple subtitle sources

[![Build Status](https://travis-ci.org/PtrTn/AutoSubtitles.svg?branch=master)](https://travis-ci.org/PtrTn/AutoSubtitles)
[![Code Coverage](https://scrutinizer-ci.com/g/PtrTn/AutoSubtitles/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PtrTn/AutoSubtitles/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PtrTn/AutoSubtitles/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PtrTn/AutoSubtitles/?branch=master)

# Requirements
In order to run this project, the following tools are required
- Php 5.6 or higher
- [Composer](https://getcomposer.org/)
- [Opensubtitles.org](https://www.opensubtitles.org) account (optional)

# Installation
Installing this project can be done with the following steps:
1. `git clone https://github.com/PtrTn/AutoSubtitles.git`
2. `cd AutoSubtitles`
3. `composer install`

Optional (skipping this step will prevent downloading subtitles from Opensubtitles):
4. `cp app/config.yml.dist app/config.yml`
5. Enter username and password
6. For development purposes the default user agent can be used, in other cases [a new user agent should be requested](http://trac.opensubtitles.org/projects/opensubtitles/wiki/DevReadFirst)

# Usage
After installing, subtitles can be downloaded using the following command:

`bin/console app:subtitles:download {video file}`

Running this command will download subtitles for the given video file. 
Subtitles are matched based on video hash, rather than filename which proves to be more accurate.
Subtitles are downloaded from [SubDb.com](http://thesubdb.com/) and [Opensubtitles.org](https://www.opensubtitles.org).
Downloaded subtitle files are renamed to match the given input video file and will have a suffix indicating its source.

# Example
Running the following command:

`bin/console app:subtitles:download var/Legion.S01E01.720p.HDTV.x264-FLEET[eztv].mkv`

Will place the following two files in the same directory

- `Legion.S01E01.720p.HDTV.x264-FLEET[eztv].OpenSubtitles.srt`
- `Legion.S01E01.720p.HDTV.x264-FLEET[eztv].SubDb.srt`

Opening the video file in [VLC player](http://www.videolan.org/vlc/index.html) will automatically load the subtitle files as below

![alt text](http://i.imgur.com/8EA0YSX.png)

# Wishlist
- Configurable languages
- Allow downloading of subtitles for multiple files at once
- Checking for rate limits
- Caching
- Domain specific exceptions for nicer reporting
- Async downloading
- Client side application
