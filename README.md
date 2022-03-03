# Configurable Interface

A lot of scripts and packages in modern PHP demand one or more configuration classes. Mostly, those are a set of properties that can be set, changed or retrieved. However, some of the configurations have a peculiar behaviour - such as boolean properties. Also, we want some of the settings to be manageable in the future - for some other we want values to remain immutable after a first setup.

There are plenty of proposed interfaces for that - what is different in this Configurable interface are two methods in particular: immutable() and switch().

This packages brings a Configurable interface and an abstract that comprises a very objective implementation of that. Shortly, we are also going to provide a trait with the same function.

Equipped with standard methods for this kind of class, such as **get()**, **set()** and **getDefaults** (this last retrieving all properties as they are in that moment), both the interface and the abstract propose two new methods:

## The immutable() method

The **immutable** method allows a property to be set or redefined (if the class already brings any default value) just once. After that, the property key is stored in a private variable and any new attempt of setting new values will be ignored.

## The switch() method

This method provides a quick and simpler way of changing one or more boolean properties. As the name suggests, any property set as FALSE will be switched to TRUE, so as it makes all TRUE values to become FALSE.


