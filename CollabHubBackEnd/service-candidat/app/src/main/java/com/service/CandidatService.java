package com.service;

import org.springframework.stereotype.Service;
import com.repository.CandidatRepository;
import java.util.List;
import com.model.Candidat;
import org.springframework.beans.factory.annotation.Autowired;

@Service
public class CandidatService {

@Autowired
private CandidatRepository candidatRepository;

public List<Candidat> findAll() {
    return candidatRepository.findAll();
}

}
