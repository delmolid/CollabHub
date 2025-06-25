package com.controller;

import org.springframework.web.bind.annotation.RestController;
import com.service.CandidatService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import java.util.List;
import com.model.Candidat;
import org.springframework.web.bind.annotation.GetMapping;

@RestController
public class CandidatController {

    private final CandidatService candidatService;

    @Autowired
    public CandidatController(CandidatService candidatService) {
        this.candidatService = candidatService;
    }

    @GetMapping(value = "/candidat")
    public List<Candidat> getAllCandidats() {
        return candidatService.findAll();
    }
}
