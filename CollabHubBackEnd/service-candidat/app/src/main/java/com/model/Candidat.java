package com.model;

import java.util.Date;
import jakarta.persistence.Entity;
import jakarta.persistence.Table;
import jakarta.persistence.Id;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Column;
import jakarta.persistence.Enumerated;
import jakarta.persistence.EnumType;
import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Past;
import com.model.Language;

@Entity
@Table(name = "candidat")
public class Candidat {
@Id
@GeneratedValue(strategy = GenerationType.IDENTITY)
private Long id;

@NotBlank
@Column(name = "first_name", length = 250)
private String firstName;

@NotBlank
@Column(name = "last_name", length = 250)
private String lastName;

@NotBlank
@Email
@Column(name = "email", unique = true, length = 250)
private String email;

@NotBlank
@Column(name = "phone", unique = true, length = 250)
private String phone;

@Column(name = "picture", length = 1000)
private String picture;

@Past
@NotNull
@Column(name = "date_birth")
private Date dateBirth;

@Column(name = "adress")
private String address;

@Column(name = "link_linkedin")
private String linkLinkedin;

@NotBlank
@Column(name = "description")
private String description;

@Column(name = "link_Github")
private String linkGithub;

@Column(name = "link_portfolio")
private String linkPortfolio;

@NotNull
@Enumerated(EnumType.STRING)
@Column(name = "language")
private Language language;

@NotBlank
@Column(name = "interests")
private String interests;

@NotBlank
@Column(name = "cv")
private String cv;

@Column(name = "created_at")
private Date createdAt;

// Getters and Setters

public Long getId() {
    return id;
}

public void setId(Long id) {
    this.id = id;
}
public String getFirstName() {
    return firstName;
}

public void setFirstName(String firstName) {
    this.firstName = firstName;
}
public String getLastName() {
    return lastName;
}

public void setLastName(String lastName) {
    this.lastName = lastName;
}
public String getEmail() {
    return email;
}

public void setEmail(String email) {
    this.email = email;
}
public String getPhone() {
    return phone;
}

public void setPhone(String phone) {
    this.phone = phone;
}
public String getPicture() {
    return picture;
}

public void setPicture(String picture) {
    this.picture = picture;
}
public String getAddress() {
    return address;
}

public void setAddress(String address) {
    this.address = address;
}
public Date getDateBirth() {
    return dateBirth;
}

public void setDateBirth(Date dateBirth) {
    this.dateBirth = dateBirth;
}
public String getLinkLinkedin() {
    return linkLinkedin;
}

public void setLinkLinkedin(String linkLinkedin) {
    this.linkLinkedin = linkLinkedin;
}
public String getDescription() {
    return description;
}

public void setDescription(String description) {
    this.description = description;
}
public String getLinkGithub() {
    return linkGithub;
}

public void setLinkGithub(String linkGithub) {
    this.linkGithub = linkGithub;
}
public String getLinkPortfolio() {
    return linkPortfolio;
}

public void setLinkPortfolio(String linkPortfolio) {
    this.linkPortfolio = linkPortfolio;
}
public Language getLanguage() {
    return language;
}

public void setLanguage(Language language) {
    this.language = language;
}

public String getInterests() {
    return interests;
}

public void setInterests(String interests) {
    this.interests = interests;
}
public String getCv() {
    return cv;
}

public void setCv(String cv) {
    this.cv = cv;
}
public Date getCreatedAt() {
    return createdAt;
}

public void setCreatedAt(Date createdAt) {
    this.createdAt = createdAt;
}
}
