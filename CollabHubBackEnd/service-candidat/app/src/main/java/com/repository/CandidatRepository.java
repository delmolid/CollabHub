package com.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import com.model.Candidat;
import java.util.List;

public interface CandidatRepository extends JpaRepository<Candidat, Long> {
    Candidat findByEmail(String email);
    Candidat findByPhone(String phone);
    Candidat findByLinkLinkedin(String linkLinkedin);
    Candidat findByLinkGithub(String linkGithub);
    List<Candidat> findAll();
  
}
